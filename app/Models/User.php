<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

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
        ];
    }

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

    // Get dashboard route based on role
    public function getDashboardRoute()
    {
        switch ($this->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'staff':
                return route('staff.dashboard');
            case 'student':
                return route('student.dashboard');
            default:
                return route('login');
        }
    }

    // Get role display name
    public function getRoleDisplayName()
    {
        return ucfirst($this->role);
    }
}