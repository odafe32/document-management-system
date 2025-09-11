<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'staff_id',
        'subject',
        'message',
        'attachment',
        'status',
        'reply',
        'replied_at',
        'is_read',
        'priority',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'replied_at' => 'datetime',
        'is_read' => 'boolean',
        'priority' => 'integer',
    ];

    /**
     * Get the student who submitted the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the staff member handling the feedback.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Scope a query to only include pending feedbacks.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include in-review feedbacks.
     */
    public function scopeInReview($query)
    {
        return $query->where('status', 'in_review');
    }

    /**
     * Scope a query to only include resolved feedbacks.
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /**
     * Scope a query to only include unread feedbacks.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query by priority.
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to search feedbacks.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('subject', 'like', "%{$search}%")
              ->orWhere('message', 'like', "%{$search}%")
              ->orWhereHas('user', function ($userQuery) use ($search) {
                  $userQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_review' => 'In Review',
            'resolved' => 'Resolved',
            default => ucfirst($this->status)
        };
    }

    /**
     * Get the priority display name.
     */
    public function getPriorityDisplayAttribute()
    {
        return match($this->priority) {
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
            default => 'Low'
        };
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'pending' => 'status-pending',
            'in_review' => 'status-in-review',
            'resolved' => 'status-resolved',
            default => 'status-pending'
        };
    }

    /**
     * Get priority badge class.
     */
    public function getPriorityBadgeClassAttribute()
    {
        return match($this->priority) {
            1 => 'priority-low',
            2 => 'priority-medium',
            3 => 'priority-high',
            default => 'priority-low'
        };
    }

    /**
     * Get attachment URL if exists.
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? Storage::url($this->attachment) : null;
    }

    /**
     * Get attachment filename.
     */
    public function getAttachmentFilenameAttribute()
    {
        return $this->attachment ? basename($this->attachment) : null;
    }

    /**
     * Check if feedback has been replied to.
     */
    public function getHasReplyAttribute()
    {
        return !empty($this->reply);
    }

    /**
     * Mark feedback as read.
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Assign to staff member.
     */
    public function assignToStaff($staffId)
    {
        $this->update([
            'staff_id' => $staffId,
            'status' => 'in_review'
        ]);
    }

    /**
     * Add reply to feedback.
     */
    public function addReply($reply, $staffId = null)
    {
        $this->update([
            'reply' => $reply,
            'replied_at' => now(),
            'staff_id' => $staffId ?: $this->staff_id,
            'status' => 'resolved'
        ]);
    }

    /**
     * Get time since submission.
     */
    public function getTimeSinceSubmissionAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get response time if replied.
     */
    public function getResponseTimeAttribute()
    {
        if (!$this->replied_at) {
            return null;
        }
        
        return $this->created_at->diffInHours($this->replied_at) . ' hours';
    }
}