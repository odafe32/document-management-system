<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Announcement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'category',
        'attachment',
        'visibility',
        'expiry_date',
        'views',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    /**
     * Get the user that created the announcement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active announcements.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include non-expired announcements.
     */
    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_date')
              ->orWhere('expiry_date', '>=', now()->toDateString());
        });
    }

    /**
     * Scope a query by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query by visibility.
     */
    public function scopeByVisibility($query, $visibility)
    {
        return $query->where('visibility', $visibility);
    }

    /**
     * Scope a query to search announcements.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('body', 'like', "%{$search}%");
        });
    }

    /**
     * Get the category display name.
     */
    public function getCategoryDisplayAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->category));
    }

    /**
     * Get the visibility display name.
     */
    public function getVisibilityDisplayAttribute()
    {
        return ucfirst($this->visibility);
    }

    /**
     * Check if announcement is expired.
     */
    public function getIsExpiredAttribute()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
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
     * Increment views count.
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        if (!$this->is_active) {
            return 'status-inactive';
        }
        
        if ($this->is_expired) {
            return 'status-expired';
        }
        
        return 'status-active';
    }

    /**
     * Get status text.
     */
    public function getStatusTextAttribute()
    {
        if (!$this->is_active) {
            return 'Inactive';
        }
        
        if ($this->is_expired) {
            return 'Expired';
        }
        
        return 'Active';
    }
}