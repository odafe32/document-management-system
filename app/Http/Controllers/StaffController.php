<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function showDashboard()
    {
        $viewData = [
           'meta_title'=> 'Staff Dashboard | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('staff.dashboard', $viewData);
    }

    public function showProfile()
    {
        $user = Auth::user();
        
        $viewData = [
           'meta_title'=> 'Staff Profile | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'user' => $user,
        ];

        return view('staff.profile', $viewData);
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

        return view('staff.profile-edit', $viewData);
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

            return redirect()->route('staff.profile')->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    // Document Management Methods
    public function showDocuments(Request $request)
    {
        $user = Auth::user();
        
        // Get filter parameters
        $category = $request->get('category');
        $visibility = $request->get('visibility');
        $search = $request->get('search');

        // Build query
        $query = Document::where('user_id', $user->id)->latest();

        // Apply filters
        if ($category) {
            $query->where('category', $category);
        }

        if ($visibility) {
            $query->where('visibility', $visibility);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $documents = $query->paginate(10);
        
        // Get statistics
        $stats = [
            'total' => Document::where('user_id', $user->id)->count(),
            'public' => Document::where('user_id', $user->id)->where('visibility', 'public')->count(),
            'private' => Document::where('user_id', $user->id)->where('visibility', 'private')->count(),
            'downloads' => Document::where('user_id', $user->id)->sum('downloads'),
        ];

        $viewData = [
           'meta_title'=> 'Documents | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'documents' => $documents,
           'stats' => $stats,
           'currentCategory' => $category,
           'currentVisibility' => $visibility,
           'currentSearch' => $search,
        ];

        return view('staff.documents', $viewData);
    }

    public function storeDocument(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:lecture,timetable,memo,other',
            'visibility' => 'required|in:public,private',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png,gif|max:10240', // 10MB max
        ]);

        try {
            // Store the file
            $filePath = $request->file('file')->store('documents', 'public');

            // Create document record
            Document::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'file_path' => $filePath,
                'visibility' => $request->visibility,
            ]);

            return redirect()->route('staff.documents')->with('success', 'Document uploaded successfully!');

        } catch (\Exception $e) {
            Log::error('Document upload failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to upload document. Please try again.']);
        }
    }

    public function editDocument(Document $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to document.');
        }

        $viewData = [
           'meta_title'=> 'Edit Document | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'document' => $document,
        ];

        return view('staff.documents-edit', $viewData);
    }

    public function updateDocument(Request $request, Document $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to document.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'required|in:lecture,timetable,memo,other',
            'visibility' => 'required|in:public,private',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,txt,jpg,jpeg,png,gif|max:10240', // 10MB max
        ]);

        try {
            // Handle file replacement
            if ($request->hasFile('file')) {
                // Delete old file
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                // Store new file
                $filePath = $request->file('file')->store('documents', 'public');
                $document->file_path = $filePath;
            }

            // Update document details
            $document->update([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'visibility' => $request->visibility,
            ]);

            return redirect()->route('staff.documents')->with('success', 'Document updated successfully!');

        } catch (\Exception $e) {
            Log::error('Document update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update document. Please try again.']);
        }
    }

    public function destroyDocument(Document $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to document.');
        }

        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete document record
            $document->delete();

            return redirect()->route('staff.documents')->with('success', 'Document deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Document deletion failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete document. Please try again.']);
        }
    }

    public function downloadDocument(Document $document)
    {
        // Check if document exists and is accessible
        if ($document->visibility === 'private' && $document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to document.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        // Increment download count
        $document->incrementDownloads();

        // Return file download
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_extension);
    }

    public function showAnnouncement()
    {
        $viewData = [
           'meta_title'=> 'Announcements | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('staff.announcement', $viewData);
    }

    public function showFeedbacks()
    {
        $viewData = [
           'meta_title'=> 'Feedbacks | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('staff.feedbacks', $viewData);
    }
}