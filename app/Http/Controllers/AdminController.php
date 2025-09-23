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

class AdminController extends Controller
{
    public function showDashboard()
    {
        $viewData = [
           'meta_title'=> 'Admin Dashboard | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('admin.dashboard', $viewData);
    }

    public function showProfile()
    {
        $user = Auth::user();
        
        $viewData = [
           'meta_title'=> 'Admin Profile | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'user' => $user,
        ];

        return view('admin.profile', $viewData);
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

        return view('admin.profile-edit', $viewData);
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

            return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    // Document Management Methods - Admin can see ALL documents
    public function showDocuments(Request $request)
    {
        // Get filter parameters
        $category = $request->get('category');
        $visibility = $request->get('visibility');
        $search = $request->get('search');
        $staff_filter = $request->get('staff');

        // Build query - Admin sees ALL documents
        $query = Document::with('user')->latest();

        // Apply filters
        if ($category) {
            $query->where('category', $category);
        }

        if ($visibility) {
            $query->where('visibility', $visibility);
        }

        if ($staff_filter) {
            $query->where('user_id', $staff_filter);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $documents = $query->paginate(10);
        
        // Get statistics
        $stats = [
            'total' => Document::count(),
            'public' => Document::where('visibility', 'public')->count(),
            'private' => Document::where('visibility', 'private')->count(),
            'downloads' => Document::sum('downloads'),
        ];

        // Get all staff members for filter dropdown
        $staffMembers = User::whereIn('role', ['admin', 'staff'])->orderBy('name')->get();

        $viewData = [
           'meta_title'=> 'All Documents | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'pageTitle' => 'All Documents',
           'documents' => $documents,
           'stats' => $stats,
           'staffMembers' => $staffMembers,
           'currentCategory' => $category,
           'currentVisibility' => $visibility,
           'currentSearch' => $search,
           'currentStaff' => $staff_filter,
        ];

        return view('admin.documents', $viewData);
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

            return redirect()->route('admin.documents')->with('success', 'Document uploaded successfully!');

        } catch (\Exception $e) {
            Log::error('Document upload failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to upload document. Please try again.']);
        }
    }

    public function editDocument(Document $document)
    {
        // Admin can edit any document - no ownership check needed
        $viewData = [
           'meta_title'=> 'Edit Document | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
           'pageTitle' => 'Edit Document',
           'document' => $document,
        ];

        return view('admin.documents-edit', $viewData);
    }

    public function updateDocument(Request $request, Document $document)
    {
        // Admin can update any document - no ownership check needed
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

            return redirect()->route('admin.documents')->with('success', 'Document updated successfully!');

        } catch (\Exception $e) {
            Log::error('Document update failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update document. Please try again.']);
        }
    }

    public function destroyDocument(Document $document)
    {
        // Admin can delete any document - no ownership check needed
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Delete document record
            $document->delete();

            return redirect()->route('admin.documents')->with('success', 'Document deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Document deletion failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete document. Please try again.']);
        }
    }

    public function downloadDocument(Document $document)
    {
        // Admin can download any document - no visibility check needed
        
        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        // Increment download count
        $document->incrementDownloads();

        // Return file download
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_extension);
    }


public function showAnnouncements(Request $request)
{
    // Build query - Admin sees ALL announcements
    $query = Announcement::with('user')->latest();

    // Apply filters
    if ($request->filled('category')) {
        $query->byCategory($request->category);
    }

    if ($request->filled('visibility')) {
        $query->byVisibility($request->visibility);
    }

    if ($request->filled('status')) {
        if ($request->status === 'active') {
            $query->active()->notExpired();
        } elseif ($request->status === 'expired') {
            $query->where('expiry_date', '<', now()->toDateString());
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }
    }

    if ($request->filled('staff')) {
        $query->where('user_id', $request->staff);
    }

    if ($request->filled('search')) {
        $query->search($request->search);
    }

    $announcements = $query->paginate(10);

    // Get all staff members for filter dropdown
    $staffMembers = User::whereIn('role', ['admin', 'staff'])->orderBy('name')->get();

    // Statistics - Admin sees all announcements
    $stats = [
        'total' => Announcement::count(),
        'active' => Announcement::active()->notExpired()->count(),
        'expired' => Announcement::where('expiry_date', '<', now()->toDateString())->count(),
        'views' => Announcement::sum('views'),
    ];

    $viewData = [
        'meta_title' => 'All Announcements | Nsuk Document Management System',
        'meta_desc' => 'Manage all announcements and notifications',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'All Announcements',
        'announcements' => $announcements,
        'stats' => $stats,
        'staffMembers' => $staffMembers,
        'currentCategory' => $request->category,
        'currentVisibility' => $request->visibility,
        'currentStatus' => $request->status,
        'currentStaff' => $request->staff,
        'currentSearch' => $request->search,
    ];

    return view('admin.announcements', $viewData);
}

public function createAnnouncement()
{
    $viewData = [
        'meta_title' => 'Create Announcement | Nsuk Document Management System',
        'meta_desc' => 'Create a new announcement',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'Create Announcement',
    ];

    return view('admin.announcements-create', $viewData);
}

public function storeAnnouncement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'category' => 'required|in:general,academic,exam,timetable,memo,other',
        'visibility' => 'required|in:public,staff,student',
        'expiry_date' => 'nullable|date|after:today',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:5120', // 5MB max
    ]);

    try {
        $announcementData = [
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'visibility' => $request->visibility,
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->has('is_active'),
        ];

        // Handle file attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('announcements', $filename, 'public');
            $announcementData['attachment'] = $path;
        }

        Announcement::create($announcementData);

        return redirect()->route('admin.announcements')->with('success', 'Announcement created successfully!');

    } catch (\Exception $e) {
        Log::error('Announcement creation failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to create announcement. Please try again.'])->withInput();
    }
}

public function editAnnouncement(Announcement $announcement)
{
    // Admin can edit any announcement - no ownership check needed
    $viewData = [
        'meta_title' => 'Edit Announcement | Nsuk Document Management System',
        'meta_desc' => 'Edit announcement details',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'Edit Announcement',
        'announcement' => $announcement,
    ];

    return view('admin.announcements-edit', $viewData);
}

public function updateAnnouncement(Request $request, Announcement $announcement)
{
    // Admin can update any announcement - no ownership check needed
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'category' => 'required|in:general,academic,exam,timetable,memo,other',
        'visibility' => 'required|in:public,staff,student',
        'expiry_date' => 'nullable|date|after:today',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:5120', // 5MB max
    ]);

    try {
        $announcementData = [
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'visibility' => $request->visibility,
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->has('is_active'),
        ];

        // Handle file attachment
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('announcements', $filename, 'public');
            $announcementData['attachment'] = $path;
        }

        $announcement->update($announcementData);

        return redirect()->route('admin.announcements')->with('success', 'Announcement updated successfully!');

    } catch (\Exception $e) {
        Log::error('Announcement update failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to update announcement. Please try again.'])->withInput();
    }
}

public function destroyAnnouncement(Announcement $announcement)
{
    // Admin can delete any announcement - no ownership check needed
    try {
        // Delete attachment if exists
        if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
            Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();

        return redirect()->route('admin.announcements')->with('success', 'Announcement deleted successfully!');

    } catch (\Exception $e) {
        Log::error('Announcement deletion failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to delete announcement. Please try again.']);
    }
}

public function downloadAnnouncementAttachment(Announcement $announcement)
{
    // Admin can download any attachment - no ownership check needed
    if (!$announcement->attachment || !Storage::disk('public')->exists($announcement->attachment)) {
        abort(404, 'Attachment not found.');
    }

    return Storage::disk('public')->download($announcement->attachment, $announcement->attachment_filename);
}

}