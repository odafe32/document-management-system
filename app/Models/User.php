<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'matric_number',
        'staff_id',
        'avatar',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'department',
        'faculty',
        'level',
        'status',
        'last_login_at',
        // Staff directory fields
        'designation',
        'office_location',
        'office_hours',
        'courses_handled',
        'specialization',
        'qualification',
        'bio',
        'show_in_directory',
        'linkedin_url',
        'research_interests',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'date_of_birth' => 'date',
            'show_in_directory' => 'boolean',
        ];
    }

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    // Role checking methods
    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Scopes for filtering by role
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Staff directory specific scopes
    public function scopeInDirectory($query)
    {
        return $query->where('show_in_directory', true);
    }

    public function scopeStaffDirectory($query)
    {
        return $query->whereIn('role', ['staff', 'admin'])
                    ->where('status', 'active')
                    ->where('show_in_directory', true);
    }

    public function scopeByDepartment($query, $department)
    {
        if ($department) {
            return $query->where('department', $department);
        }
        return $query;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('courses_handled', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    // Relationships

    /**
     * Get the feedbacks submitted by this user.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    /**
     * Get the feedbacks assigned to this admin/staff member.
     */
    public function assignedFeedbacks()
    {
        return $this->hasMany(Feedback::class, 'admin_id');
    }

    /**
     * Get the documents uploaded by this user.
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    /**
     * Get the announcements created by this user.
     */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'user_id');
    }

    // Get dashboard route based on role
    public function getDashboardRoute()
    {
        switch ($this->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'staff':
                return route('staff.dashboard');
            case 'student':
                return route('student.home');
            default:
                return route('login');
        }
    }

    // Get role display name
    public function getRoleDisplayName()
    {
        return ucfirst($this->role);
    }

    // Staff directory helper methods
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        return null;
    }

    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        return substr($initials, 0, 2); // Return first 2 initials
    }

    public function getCoursesArrayAttribute()
    {
        if (!$this->courses_handled) {
            return [];
        }
        
        // Try to decode as JSON first, if that fails, split by comma
        $courses = json_decode($this->courses_handled, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $courses;
        }
        
        return array_map('trim', explode(',', $this->courses_handled));
    }

    public function getDesignationDisplayAttribute()
    {
        return $this->designation ?: 'Staff Member';
    }

    public function getOfficeHoursDisplayAttribute()
    {
        return $this->office_hours ?: 'Contact for appointment';
    }

    public function getOfficeLocationDisplayAttribute()
    {
        return $this->office_location ?: 'Contact for location';
    }

    public function getQualificationDisplayAttribute()
    {
        return $this->qualification ?: 'Not specified';
    }

    public function getBioDisplayAttribute()
    {
        return $this->bio ?: 'No biography available.';
    }

    public function getSpecializationDisplayAttribute()
    {
        return $this->specialization ?: 'General';
    }

    // Check if staff member handles a specific course
    public function handlesCourse($courseName)
    {
        $courses = $this->courses_array;
        return in_array(strtolower($courseName), array_map('strtolower', $courses));
    }

    // Get contact information for directory
    public function getContactInfoAttribute()
    {
        $contact = [];
        
        if ($this->email) {
            $contact['email'] = $this->email;
        }
        
        if ($this->phone) {
            $contact['phone'] = $this->phone;
        }
        
        if ($this->office_location) {
            $contact['office'] = $this->office_location;
        }
        
        return $contact;
    }

    // Feedback-related helper methods

    /**
     * Get pending feedbacks count for this user.
     */
    public function getPendingFeedbacksCountAttribute()
    {
        return $this->feedbacks()->where('status', 'pending')->count();
    }

    /**
     * Get resolved feedbacks count for this user.
     */
    public function getResolvedFeedbacksCountAttribute()
    {
        return $this->feedbacks()->where('status', 'resolved')->count();
    }

    /**
     * Get total feedbacks count for this user.
     */
    public function getTotalFeedbacksCountAttribute()
    {
        return $this->feedbacks()->count();
    }

    /**
     * Check if user has any unread feedback replies.
     */
    public function hasUnreadFeedbackReplies()
    {
        return $this->feedbacks()
                   ->where('status', 'resolved')
                   ->whereNotNull('reply')
                   ->where('is_read', false)
                   ->exists();
    }

    /**
     * Get the most recent feedback for this user.
     */
    public function getLatestFeedbackAttribute()
    {
        return $this->feedbacks()->latest()->first();
    }
}