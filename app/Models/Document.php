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
        if (Storage::exists($this->file_path)) {
            $bytes = Storage::size($this->file_path);
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

    // Scope by category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
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
}