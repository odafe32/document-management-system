<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'file_path',
        'visibility',
        'target_department', // New field for department targeting
        'downloads',
    ];

    protected $casts = [
        'downloads' => 'integer',
    ];

    // Relationship with User (staff who uploaded)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Get file URL
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    // Get file size in human readable format
    public function getFileSizeAttribute()
    {
        if (Storage::disk('public')->exists($this->file_path)) {
            $bytes = Storage::disk('public')->size($this->file_path);
            return $this->formatBytes($bytes);
        }
        return 'Unknown';
    }

    // Get file extension
    public function getFileExtensionAttribute()
    {
        return pathinfo($this->file_path, PATHINFO_EXTENSION);
    }

    // Get original filename
    public function getOriginalFilenameAttribute()
    {
        return basename($this->file_path);
    }

    // Format bytes to human readable
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    // Increment download count
    public function incrementDownloads()
    {
        $this->increment('downloads');
    }

    // Scope for public documents
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    // Scope for private documents
    public function scopePrivate($query)
    {
        return $query->where('visibility', 'private');
    }

    // Scope for student-visible documents
    public function scopeStudentVisible($query)
    {
        return $query->where('visibility', 'public');
    }

    // Scope by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope by target department - improved logic
    public function scopeByDepartment($query, $department)
    {
        return $query->where(function($q) use ($department) {
            // Show documents that:
            // 1. Have no target department (general documents)
            // 2. Have empty target department (general documents)
            // 3. Target the specific department (case-insensitive)
            $q->whereNull('target_department')
              ->orWhere('target_department', '')
              ->orWhere('target_department', $department);
              
            // Also handle case-insensitive matching if department is provided
            if ($department) {
                $q->orWhereRaw('LOWER(TRIM(target_department)) = ?', [strtolower(trim($department))]);
            }
        });
    }

    // Scope to search documents
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhereHas('user', function($userQuery) use ($search) {
                  $userQuery->where('name', 'like', "%{$search}%");
              });
        });
    }

    // Get category display name
    public function getCategoryDisplayAttribute()
    {
        return ucfirst($this->category);
    }

    // Get visibility display name
    public function getVisibilityDisplayAttribute()
    {
        return ucfirst($this->visibility);
    }

    // Get the target department display name
    public function getTargetDepartmentDisplayAttribute()
    {
        return $this->target_department ? ucfirst($this->target_department) : 'All Departments';
    }

    // Check if document is for a specific department
    public function getIsDepartmentSpecificAttribute()
    {
        return !empty($this->target_department);
    }

    // Check if document is general (for all departments)
    public function getIsGeneralAttribute()
    {
        return empty($this->target_department);
    }

    // Check if a student can access this document
    public function canBeAccessedByStudent($user): bool
    {
        // Check visibility - must be public for students
        if ($this->visibility !== 'public') {
            return false;
        }

        // Check department access
        if (!empty($this->target_department)) {
            $targetDept = strtolower(trim($this->target_department));
            $userDept = strtolower(trim($user->department ?? ''));
            
            if ($targetDept !== $userDept) {
                return false;
            }
        }

        return true;
    }

    // Get file icon based on extension
    public function getFileIconAttribute()
    {
        $extension = strtolower($this->file_extension);
        
        $icons = [
            'pdf' => 'fas fa-file-pdf',
            'doc' => 'fas fa-file-word',
            'docx' => 'fas fa-file-word',
            'xls' => 'fas fa-file-excel',
            'xlsx' => 'fas fa-file-excel',
            'ppt' => 'fas fa-file-powerpoint',
            'pptx' => 'fas fa-file-powerpoint',
            'txt' => 'fas fa-file-alt',
            'jpg' => 'fas fa-file-image',
            'jpeg' => 'fas fa-file-image',
            'png' => 'fas fa-file-image',
            'gif' => 'fas fa-file-image',
        ];

        return $icons[$extension] ?? 'fas fa-file';
    }

    // Get file color based on extension
    public function getFileColorAttribute()
    {
        $extension = strtolower($this->file_extension);
        
        $colors = [
            'pdf' => '#dc2626',
            'doc' => '#2563eb',
            'docx' => '#2563eb',
            'xls' => '#059669',
            'xlsx' => '#059669',
            'ppt' => '#ea580c',
            'pptx' => '#ea580c',
            'txt' => '#6b7280',
            'jpg' => '#7c3aed',
            'jpeg' => '#7c3aed',
            'png' => '#7c3aed',
            'gif' => '#7c3aed',
        ];

        return $colors[$extension] ?? '#6b7280';
    }
}