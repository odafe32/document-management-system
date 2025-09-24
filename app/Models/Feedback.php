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
        'admin_id',        // Updated to admin_id for consistency
        'staff_id',        // Keep for backward compatibility if needed
        'subject',
        'message',
        'attachment',
        'status',
        'reply',
        'replied_at',
        'assigned_at',     // Added for tracking assignment time
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
        'assigned_at' => 'datetime',
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
     * Get the admin handling the feedback.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get the staff member handling the feedback (for backward compatibility).
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
                  $userQuery->where('name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
              });
        });
    }

    /**
     * Scope a query for feedbacks available to a specific admin.
     * This includes feedbacks assigned to the admin or unassigned feedbacks.
     */
    public function scopeAvailableToAdmin($query, $adminId)
    {
        return $query->where(function($q) use ($adminId) {
            $q->where('admin_id', $adminId)
              ->orWhereNull('admin_id');
        });
    }

    /**
     * Scope a query for unassigned feedbacks.
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('admin_id');
    }

    /**
     * Scope a query for feedbacks assigned to a specific admin.
     */
    public function scopeAssignedToAdmin($query, $adminId)
    {
        return $query->where('admin_id', $adminId);
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

    /**
     * Get human readable replied at time.
     */
    public function getRepliedAtHumanAttribute()
    {
        return $this->replied_at ? $this->replied_at->diffForHumans() : null;
    }

    /**
     * Check if feedback is assigned to any admin.
     */
    public function getIsAssignedAttribute()
    {
        return !is_null($this->admin_id);
    }

    /**
     * Check if feedback is overdue (pending for more than 24 hours).
     */
    public function getIsOverdueAttribute()
    {
        if ($this->status !== 'pending') {
            return false;
        }
        
        return $this->created_at->diffInHours(now()) > 24;
    }

    /**
     * Mark feedback as read.
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update(['is_read' => true]);
        }
    }

    /**
     * Assign to admin.
     */
    public function assignToAdmin($adminId)
    {
        $this->update([
            'admin_id' => $adminId,
            'status' => 'in_review',
            'assigned_at' => now(),
        ]);
    }

    /**
     * Assign to staff member (for backward compatibility).
     */
    public function assignToStaff($staffId)
    {
        $this->update([
            'staff_id' => $staffId,
            'admin_id' => $staffId, // Also set admin_id for consistency
            'status' => 'in_review',
            'assigned_at' => now(),
        ]);
    }

    /**
     * Unassign from current admin.
     */
    public function unassign()
    {
        $this->update([
            'admin_id' => null,
            'staff_id' => null,
            'status' => 'pending',
            'assigned_at' => null,
        ]);
    }

    /**
     * Add reply to feedback.
     */
    public function addReply($reply, $adminId = null)
    {
        $updateData = [
            'reply' => $reply,
            'replied_at' => now(),
            'status' => 'resolved'
        ];

        // If adminId is provided and feedback is not assigned, assign it
        if ($adminId && !$this->admin_id) {
            $updateData['admin_id'] = $adminId;
            $updateData['assigned_at'] = now();
        }

        $this->update($updateData);
    }

    /**
     * Update feedback status.
     */
    public function updateStatus($status, $adminId = null)
    {
        $updateData = ['status' => $status];

        // If adminId is provided and feedback is not assigned, assign it
        if ($adminId && !$this->admin_id) {
            $updateData['admin_id'] = $adminId;
            $updateData['assigned_at'] = now();
        }

        $this->update($updateData);
    }

    /**
     * Update feedback priority.
     */
    public function updatePriority($priority, $adminId = null)
    {
        $updateData = ['priority' => $priority];

        // If adminId is provided and feedback is not assigned, assign it
        if ($adminId && !$this->admin_id) {
            $updateData['admin_id'] = $adminId;
            $updateData['assigned_at'] = now();
        }

        $this->update($updateData);
    }

    /**
     * Check if admin can access this feedback.
     */
    public function canBeAccessedByAdmin($adminId)
    {
        return $this->admin_id === $adminId || $this->admin_id === null;
    }

    /**
     * Check if admin can modify this feedback.
     */
    public function canBeModifiedByAdmin($adminId)
    {
        return $this->admin_id === $adminId || $this->admin_id === null;
    }

    /**
     * Get the admin name who handled the feedback.
     */
    public function getAdminNameAttribute()
    {
        return $this->admin ? $this->admin->name : null;
    }

    /**
     * Get feedback age in hours.
     */
    public function getAgeInHoursAttribute()
    {
        return $this->created_at->diffInHours(now());
    }

    /**
     * Get feedback age in days.
     */
    public function getAgeInDaysAttribute()
    {
        return $this->created_at->diffInDays(now());
    }

    /**
     * Boot method to set default values.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($feedback) {
            // Set default priority if not provided
            if (!$feedback->priority) {
                $feedback->priority = 2; // Medium priority by default
            }

            // Set default status if not provided
            if (!$feedback->status) {
                $feedback->status = 'pending';
            }

            // Set is_read to false by default
            if (!isset($feedback->is_read)) {
                $feedback->is_read = false;
            }
        });
    }
}