<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function showHome()
    {
        $viewData = [
           'meta_title'=> 'Student HomePage | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('student.home', $viewData);
    }

    
    public function showProfile()
    {
        $user = Auth::user();
        
        $viewData = [
           'meta_title'=> 'Student Profile | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'user' => $user,
        ];

        return view('student.profile', $viewData);
    }

    public function editProfile()
    {
        $user = Auth::user();
        
        $viewData = [
           'meta_title'=> 'Edit Profile | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'user' => $user,
        ];

        return view('student.profile-edit', $viewData);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
            'department' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'current_password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Store new avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            // Update basic profile information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->date_of_birth = $request->date_of_birth;
            $user->address = $request->address;
            $user->department = $request->department;
            $user->faculty = $request->faculty;

            // Handle password change
            if ($request->filled('current_password') && $request->filled('new_password')) {
                // Verify current password
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'Current password is incorrect.']);
                }

                // Update password
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    public function showAnnouncements(Request $request)
    {
        $user = Auth::user();
        
        // Build query - Students see only announcements relevant to their department
        $query = Announcement::with('user')
            ->active() // Only active announcements
            ->notExpired() // Only non-expired announcements
            ->where(function($q) {
                // Show announcements visible to students or public
                $q->where('visibility', 'student')
                  ->orWhere('visibility', 'public');
            })
            ->where(function($q) use ($user) {
                // Show announcements for student's department or general announcements
                $q->where('target_department', $user->department)
                  ->orWhereNull('target_department') // General announcements for all departments
                  ->orWhere('target_department', ''); // Empty department means all departments
            })
            ->latest();

        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $announcements = $query->paginate(10);

        // Increment views for announcements being viewed
        foreach ($announcements as $announcement) {
            $announcement->incrementViews();
        }

        // Statistics - Only for announcements visible to this student
        $stats = [
            'total' => Announcement::active()
                ->notExpired()
                ->where(function($q) {
                    $q->where('visibility', 'student')
                      ->orWhere('visibility', 'public');
                })
                ->where(function($q) use ($user) {
                    $q->where('target_department', $user->department)
                      ->orWhereNull('target_department')
                      ->orWhere('target_department', '');
                })
                ->count(),
            'department' => Announcement::active()
                ->notExpired()
                ->where(function($q) {
                    $q->where('visibility', 'student')
                      ->orWhere('visibility', 'public');
                })
                ->where('target_department', $user->department)
                ->count(),
            'general' => Announcement::active()
                ->notExpired()
                ->where(function($q) {
                    $q->where('visibility', 'student')
                      ->orWhere('visibility', 'public');
                })
                ->where(function($q) {
                    $q->whereNull('target_department')
                      ->orWhere('target_department', '');
                })
                ->count(),
        ];

        $viewData = [
            'meta_title' => 'Department Announcements | Nsuk Document Management System',
            'meta_desc' => 'View official department announcements and notifications',
            'meta_image' => url('logo.png'),
            'pageTitle' => ucfirst($user->department) . ' Department Announcements',
            'announcements' => $announcements,
            'stats' => $stats,
            'currentCategory' => $request->category,
            'currentSearch' => $request->search,
            'userDepartment' => $user->department,
        ];

        return view('student.announcements', $viewData);
    }

    public function viewAnnouncement(Announcement $announcement)
    {
        $user = Auth::user();
        
        // Check if student can view this announcement
        $canView = ($announcement->visibility === 'student' || $announcement->visibility === 'public') &&
                   $announcement->is_active &&
                   !$announcement->is_expired &&
                   ($announcement->target_department === $user->department || 
                    $announcement->target_department === null || 
                    $announcement->target_department === '');
        
        if (!$canView) {
            abort(403, 'You do not have permission to view this announcement.');
        }

        // Increment views
        $announcement->incrementViews();

        $viewData = [
            'meta_title' => $announcement->title . ' | Nsuk Document Management System',
            'meta_desc' => Str::limit(strip_tags($announcement->body), 160),
            'meta_image' => url('logo.png'),
            'announcement' => $announcement,
        ];

        return view('student.announcement-detail', $viewData);
    }

    public function downloadAnnouncementAttachment(Announcement $announcement)
    {
        $user = Auth::user();
        
        // Check if student can access this announcement
        $canAccess = ($announcement->visibility === 'student' || $announcement->visibility === 'public') &&
                     $announcement->is_active &&
                     !$announcement->is_expired &&
                     ($announcement->target_department === $user->department || 
                      $announcement->target_department === null || 
                      $announcement->target_department === '');
        
        if (!$canAccess) {
            abort(403, 'You do not have permission to access this attachment.');
        }

        if (!$announcement->attachment || !Storage::disk('public')->exists($announcement->attachment)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('public')->download($announcement->attachment, $announcement->attachment_filename);
    }
}