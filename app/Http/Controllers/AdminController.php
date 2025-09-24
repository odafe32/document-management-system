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
// Add these methods to your AdminController class

// User Management Methods - Admin can manage ALL users
public function showUsers(Request $request)
{
    // Build query - Admin sees ALL users
    $query = User::latest();

    // Apply filters
    if ($request->filled('role')) {
        $query->where('role', $request->role);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    if ($request->filled('faculty')) {
        $query->where('faculty', $request->faculty);
    }

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
              ->orWhere('matric_number', 'like', "%{$request->search}%")
              ->orWhere('staff_id', 'like', "%{$request->search}%");
        });
    }

    $users = $query->paginate(15);

    // Get unique departments and faculties for filters
    $departments = User::whereNotNull('department')->distinct()->pluck('department')->sort();
    $faculties = User::whereNotNull('faculty')->distinct()->pluck('faculty')->sort();

    // Statistics
    $stats = [
        'total' => User::count(),
        'students' => User::students()->count(),
        'staff' => User::staff()->count(),
        'admins' => User::admins()->count(),
        'active' => User::active()->count(),
        'inactive' => User::where('status', 'inactive')->count(),
    ];

    $viewData = [
        'meta_title' => 'User Management | Nsuk Document Management System',
        'meta_desc' => 'Manage all system users',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'User Management',
        'users' => $users,
        'stats' => $stats,
        'departments' => $departments,
        'faculties' => $faculties,
        'currentRole' => $request->role,
        'currentStatus' => $request->status,
        'currentDepartment' => $request->department,
        'currentFaculty' => $request->faculty,
        'currentSearch' => $request->search,
    ];

    return view('admin.users', $viewData);
}

public function createUser()
{
    $viewData = [
        'meta_title' => 'Create User | Nsuk Document Management System',
        'meta_desc' => 'Create a new user account',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'Create User',
    ];

    return view('admin.users-create', $viewData);
}

public function storeUser(Request $request)
{
    // Base validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:admin,staff,student',
        'password' => 'required|string|min:6|confirmed',
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:male,female,other',
        'date_of_birth' => 'nullable|date|before:today',
        'address' => 'nullable|string|max:500',
        'department' => 'nullable|string|max:255',
        'faculty' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    // Role-specific validation
    if ($request->role === 'student') {
        $rules['matric_number'] = 'required|string|unique:users,matric_number';
        $rules['level'] = 'required|in:100,200,300,400,500,600';
    } elseif (in_array($request->role, ['staff', 'admin'])) {
        $rules['staff_id'] = 'required|string|unique:users,staff_id';
    }

    $request->validate($rules);

    try {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'department' => $request->department,
            'faculty' => $request->faculty,
            'status' => $request->status,
        ];

        // Role-specific fields
        if ($request->role === 'student') {
            $userData['matric_number'] = $request->matric_number;
            $userData['level'] = $request->level;
        } elseif (in_array($request->role, ['staff', 'admin'])) {
            $userData['staff_id'] = $request->staff_id;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        User::create($userData);

        return redirect()->route('admin.users')->with('success', 'User created successfully!');

    } catch (\Exception $e) {
        Log::error('User creation failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to create user. Please try again.'])->withInput();
    }
}

public function editUser(User $user)
{
    // Admin can edit any user
    $viewData = [
        'meta_title' => 'Edit User | Nsuk Document Management System',
        'meta_desc' => 'Edit user details',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'Edit User',
        'user' => $user,
    ];

    return view('admin.users-edit', $viewData);
}

public function updateUser(Request $request, User $user)
{
    // Base validation rules
    $rules = [
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->ignore($user->id),
        ],
        'role' => 'required|in:admin,staff,student',
        'phone' => 'nullable|string|max:20',
        'gender' => 'nullable|in:male,female,other',
        'date_of_birth' => 'nullable|date|before:today',
        'address' => 'nullable|string|max:500',
        'department' => 'nullable|string|max:255',
        'faculty' => 'nullable|string|max:255',
        'status' => 'required|in:active,inactive',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'password' => 'nullable|string|min:6|confirmed',
    ];

    // Role-specific validation
    if ($request->role === 'student') {
        $rules['matric_number'] = [
            'required',
            'string',
            Rule::unique('users')->ignore($user->id),
        ];
        $rules['level'] = 'required|in:100,200,300,400,500,600';
    } elseif (in_array($request->role, ['staff', 'admin'])) {
        $rules['staff_id'] = [
            'required',
            'string',
            Rule::unique('users')->ignore($user->id),
        ];
    }

    $request->validate($rules);

    try {
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'department' => $request->department,
            'faculty' => $request->faculty,
            'status' => $request->status,
        ];

        // Role-specific fields
        if ($request->role === 'student') {
            $userData['matric_number'] = $request->matric_number;
            $userData['level'] = $request->level;
            // Clear staff_id if changing to student
            $userData['staff_id'] = null;
        } elseif (in_array($request->role, ['staff', 'admin'])) {
            $userData['staff_id'] = $request->staff_id;
            // Clear student fields if changing to staff/admin
            $userData['matric_number'] = null;
            $userData['level'] = null;
        }

        // Handle password update
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $userData['avatar'] = $avatarPath;
        }

        $user->update($userData);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');

    } catch (\Exception $e) {
        Log::error('User update failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to update user. Please try again.'])->withInput();
    }
}

public function destroyUser(User $user)
{
    // Prevent admin from deleting themselves
    if ($user->id === Auth::id()) {
        return back()->withErrors(['error' => 'You cannot delete your own account.']);
    }

    try {
        // Delete avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Soft delete the user
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');

    } catch (\Exception $e) {
        Log::error('User deletion failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to delete user. Please try again.']);
    }
}

public function toggleUserStatus(User $user)
{
    // Prevent admin from deactivating themselves
    if ($user->id === Auth::id() && $user->status === 'active') {
        return back()->withErrors(['error' => 'You cannot deactivate your own account.']);
    }

    try {
        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'User activated successfully!' : 'User deactivated successfully!';
        return redirect()->route('admin.users')->with('success', $message);

    } catch (\Exception $e) {
        Log::error('User status toggle failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to update user status. Please try again.']);
    }
}

public function showFeedbacks(Request $request)
{
    // Base query - Admin sees only feedbacks assigned to them OR unassigned feedbacks
    $query = Feedback::with(['user', 'admin', 'staff'])
        ->where(function($q) {
            $q->where('admin_id', Auth::id()) // Assigned to current admin via admin_id
              ->orWhere('staff_id', Auth::id()) // Assigned to current admin via staff_id (backward compatibility)
              ->orWhere(function($subQ) {
                  $subQ->whereNull('admin_id')->whereNull('staff_id'); // Unassigned
              });
        })
        ->latest();

    // Apply filters
    if ($request->filled('status')) {
        if ($request->status === 'pending') {
            $query->pending();
        } elseif ($request->status === 'in_review') {
            $query->inReview();
        } elseif ($request->status === 'resolved') {
            $query->resolved();
        }
    }

    if ($request->filled('priority')) {
        $query->byPriority($request->priority);
    }

    if ($request->filled('assigned')) {
        if ($request->assigned === 'me') {
            $query->where(function($q) {
                $q->where('admin_id', Auth::id())
                  ->orWhere('staff_id', Auth::id());
            });
        } elseif ($request->assigned === 'unassigned') {
            $query->where(function($q) {
                $q->whereNull('admin_id')->whereNull('staff_id');
            });
        }
    }

    if ($request->filled('read')) {
        if ($request->read === 'unread') {
            $query->unread();
        } elseif ($request->read === 'read') {
            $query->where('is_read', true);
        }
    }

    if ($request->filled('search')) {
        $query->search($request->search);
    }

    $feedbacks = $query->paginate(15);

    // Statistics - Only for feedbacks related to current admin
    $stats = [
        'total' => Feedback::where(function($q) {
            $q->where('admin_id', Auth::id())
              ->orWhere('staff_id', Auth::id())
              ->orWhere(function($subQ) {
                  $subQ->whereNull('admin_id')->whereNull('staff_id');
              });
        })->count(),
        'pending' => Feedback::pending()->where(function($q) {
            $q->where('admin_id', Auth::id())
              ->orWhere('staff_id', Auth::id())
              ->orWhere(function($subQ) {
                  $subQ->whereNull('admin_id')->whereNull('staff_id');
              });
        })->count(),
        'in_review' => Feedback::inReview()->where(function($q) {
            $q->where('admin_id', Auth::id())
              ->orWhere('staff_id', Auth::id())
              ->orWhere(function($subQ) {
                  $subQ->whereNull('admin_id')->whereNull('staff_id');
              });
        })->count(),
        'resolved' => Feedback::resolved()->where(function($q) {
            $q->where('admin_id', Auth::id())
              ->orWhere('staff_id', Auth::id())
              ->orWhere(function($subQ) {
                  $subQ->whereNull('admin_id')->whereNull('staff_id');
              });
        })->count(),
        'unread' => Feedback::unread()->where(function($q) {
            $q->where('admin_id', Auth::id())
              ->orWhere('staff_id', Auth::id())
              ->orWhere(function($subQ) {
                  $subQ->whereNull('admin_id')->whereNull('staff_id');
              });
        })->count(),
        'assigned_to_me' => Feedback::where(function($q) {
            $q->where('admin_id', Auth::id())
              ->orWhere('staff_id', Auth::id());
        })->count(),
    ];

    $viewData = [
        'meta_title' => 'My Feedbacks | Nsuk Document Management System',
        'meta_desc' => 'Manage feedbacks assigned to you and available feedbacks',
        'meta_image' => url('logo.png'),
        'feedbacks' => $feedbacks,
        'stats' => $stats,
        'currentStatus' => $request->status,
        'currentPriority' => $request->priority,
        'currentAssigned' => $request->assigned,
        'currentRead' => $request->read,
        'currentSearch' => $request->search,
    ];

    return view('admin.feedbacks', $viewData);
}

public function getFeedbackDetails(Feedback $feedback)
{
    // Check if admin can access this feedback
    $canAccess = $feedback->admin_id === Auth::id() || 
                 $feedback->staff_id === Auth::id() || 
                 ($feedback->admin_id === null && $feedback->staff_id === null);
    
    if (!$canAccess) {
        return response()->json([
            'success' => false,
            'message' => 'You do not have permission to view this feedback.'
        ], 403);
    }

    try {
        // Mark as read if not already read
        if (!$feedback->is_read) {
            $feedback->markAsRead();
        }

        $feedback->load(['user', 'admin', 'staff']);

        return response()->json([
            'success' => true,
            'feedback' => [
                'id' => $feedback->id,
                'subject' => $feedback->subject,
                'message' => $feedback->message,
                'status' => $feedback->status,
                'status_display' => $feedback->status_display,
                'status_badge_class' => $feedback->status_badge_class,
                'priority' => $feedback->priority,
                'priority_display' => $feedback->priority_display,
                'priority_badge_class' => $feedback->priority_badge_class,
                'time_since_submission' => $feedback->time_since_submission,
                'has_reply' => $feedback->has_reply,
                'reply' => $feedback->reply,
                'replied_at_human' => $feedback->replied_at ? $feedback->replied_at->diffForHumans() : null,
                'attachment' => $feedback->attachment,
                'attachment_filename' => $feedback->attachment_filename,
                'admin_id' => $feedback->admin_id ?? $feedback->staff_id,
                'user' => [
                    'name' => $feedback->user->name,
                    'email' => $feedback->user->email,
                ],
                'admin' => ($feedback->admin ?? $feedback->staff) ? [
                    'name' => ($feedback->admin ?? $feedback->staff)->name,
                ] : null,
            ]
        ]);
    } catch (\Exception $e) {
        Log::error('Failed to get feedback details: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Failed to load feedback details.'
        ], 500);
    }
}

public function assignFeedback(Request $request, Feedback $feedback)
{
    // Check if admin can access this feedback
    $canAccess = $feedback->admin_id === Auth::id() || 
                 $feedback->staff_id === Auth::id() || 
                 ($feedback->admin_id === null && $feedback->staff_id === null);
    
    if (!$canAccess) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false, 
                'message' => 'You do not have permission to modify this feedback.'
            ], 403);
        }
        return back()->withErrors(['error' => 'You do not have permission to modify this feedback.']);
    }

    $request->validate([
        'action' => 'required|in:assign_to_me,unassign',
    ]);

    try {
        if ($request->action === 'assign_to_me') {
            $feedback->update([
                'admin_id' => Auth::id(),
                'staff_id' => Auth::id(), // Keep for backward compatibility
                'status' => 'in_review',
                'assigned_at' => now(),
            ]);
            $message = 'Feedback assigned to you successfully!';
        } else {
            // Only allow unassigning if it's assigned to current admin
            $isAssignedToCurrentAdmin = $feedback->admin_id === Auth::id() || $feedback->staff_id === Auth::id();
            
            if (!$isAssignedToCurrentAdmin) {
                throw new \Exception('You can only unassign feedbacks assigned to you.');
            }
            
            $feedback->update([
                'admin_id' => null,
                'staff_id' => null,
                'status' => 'pending',
                'assigned_at' => null,
            ]);
            $message = 'Feedback unassigned successfully!';
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);

    } catch (\Exception $e) {
        Log::error('Feedback assignment failed: ' . $e->getMessage());
        
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
        
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}

public function replyFeedback(Request $request, Feedback $feedback)
{
    // Check if admin can reply to this feedback
    $canReply = $feedback->admin_id === Auth::id() || 
                $feedback->staff_id === Auth::id() || 
                ($feedback->admin_id === null && $feedback->staff_id === null);
    
    if (!$canReply) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false, 
                'message' => 'You can only reply to feedbacks assigned to you.'
            ], 403);
        }
        return back()->withErrors(['error' => 'You can only reply to feedbacks assigned to you.']);
    }

    $request->validate([
        'reply' => 'required|string|min:10',
    ]);

    try {
        // Auto-assign to current admin if not assigned
        if (!$feedback->admin_id && !$feedback->staff_id) {
            $feedback->update([
                'admin_id' => Auth::id(),
                'staff_id' => Auth::id(), // Keep for backward compatibility
                'status' => 'in_review',
                'assigned_at' => now(),
            ]);
        }

        $feedback->update([
            'reply' => $request->reply,
            'replied_at' => now(),
            'status' => 'resolved'
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Reply sent successfully!']);
        }

        return back()->with('success', 'Reply sent successfully!');

    } catch (\Exception $e) {
        Log::error('Feedback reply failed: ' . $e->getMessage());
        
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Failed to send reply.'], 500);
        }
        
        return back()->withErrors(['error' => 'Failed to send reply. Please try again.']);
    }
}

public function updateFeedbackStatus(Request $request, Feedback $feedback)
{
    // Check if admin can update this feedback
    $canUpdate = $feedback->admin_id === Auth::id() || 
                 $feedback->staff_id === Auth::id() || 
                 ($feedback->admin_id === null && $feedback->staff_id === null);
    
    if (!$canUpdate) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false, 
                'message' => 'You can only update feedbacks assigned to you.'
            ], 403);
        }
        return back()->withErrors(['error' => 'You can only update feedbacks assigned to you.']);
    }

    $request->validate([
        'status' => 'required|in:pending,in_review,resolved',
        'priority' => 'sometimes|in:1,2,3',
    ]);

    try {
        // Auto-assign to current admin if not assigned
        if (!$feedback->admin_id && !$feedback->staff_id) {
            $feedback->update([
                'admin_id' => Auth::id(),
                'staff_id' => Auth::id(), // Keep for backward compatibility
                'assigned_at' => now(),
            ]);
        }

        $updateData = ['status' => $request->status];
        
        if ($request->filled('priority')) {
            $updateData['priority'] = $request->priority;
        }

        $feedback->update($updateData);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }

        return back()->with('success', 'Feedback status updated successfully!');

    } catch (\Exception $e) {
        Log::error('Feedback status update failed: ' . $e->getMessage());
        
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'message' => 'Failed to update status.'], 500);
        }
        
        return back()->withErrors(['error' => 'Failed to update status. Please try again.']);
    }
}

public function downloadFeedbackAttachment(Feedback $feedback)
{
    // Check if admin can access this feedback
    $canAccess = $feedback->admin_id === Auth::id() || 
                 $feedback->staff_id === Auth::id() || 
                 ($feedback->admin_id === null && $feedback->staff_id === null);
    
    if (!$canAccess) {
        abort(403, 'You do not have permission to access this attachment.');
    }

    if (!$feedback->attachment || !Storage::disk('public')->exists($feedback->attachment)) {
        abort(404, 'Attachment not found.');
    }

    return Storage::disk('public')->download($feedback->attachment, $feedback->attachment_filename);
}
}