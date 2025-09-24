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

class StaffController extends Controller
{public function showDashboard()
{
    $stats = [
        'documents' => [
            'total' => Document::where('user_id', Auth::id())->count(),
            'public' => Document::where('user_id', Auth::id())->where('visibility', 'public')->count(),
            'private' => Document::where('user_id', Auth::id())->where('visibility', 'private')->count(),
            'this_month' => Document::where('user_id', Auth::id())->whereMonth('created_at', now()->month)->count(),
        ],
        'announcements' => [
            'total' => Announcement::where('user_id', Auth::id())->count(),
            'active' => Announcement::where('user_id', Auth::id())->where('is_active', true)->count(),
            'expired' => Announcement::where('user_id', Auth::id())->where('expiry_date', '<', now())->count(),
            'this_week' => Announcement::where('user_id', Auth::id())->where('created_at', '>=', now()->startOfWeek())->count(),
        ],
        'feedbacks' => [
            'total' => Feedback::count(),
            'pending' => Feedback::pending()->count(),
            'in_review' => Feedback::inReview()->count(),
            'resolved' => Feedback::resolved()->count(),
        ],
        'system' => [
            'storage_used' => '45 MB',
            'files_count' => Document::count(),
            'storage_percentage' => 15,
        ]
    ];

    $recentDocuments = Document::where('user_id', Auth::id())->latest()->take(5)->get();
    $recentAnnouncements = Announcement::where('user_id', Auth::id())->latest()->take(5)->get();
    $recentFeedbacks = Feedback::latest()->take(5)->with('user')->get();
    
    $recentActivity = [
        ['user' => 'System', 'text' => 'Database backup completed', 'time' => '2 hours ago'],
        ['user' => Auth::user()->name, 'text' => 'Uploaded new document', 'time' => '3 hours ago'],
        ['user' => 'Student', 'text' => 'New feedback received', 'time' => '5 hours ago'],
    ];

    $viewData = [
        'meta_title' => 'Staff Dashboard | Nsuk Document Management System',
        'meta_desc' => 'Staff dashboard with analytics and quick actions',
        'meta_image' => url('logo.png'),
        'stats' => $stats,
        'recentDocuments' => $recentDocuments,
        'recentAnnouncements' => $recentAnnouncements,
        'recentFeedbacks' => $recentFeedbacks,
        'recentActivity' => $recentActivity,
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
  public function showAnnouncements(Request $request)
    {
        $query = Announcement::with('user')
            ->where('user_id', Auth::id())
            ->latest();

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

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $announcements = $query->paginate(10);

        // Statistics
        $stats = [
            'total' => Announcement::where('user_id', Auth::id())->count(),
            'active' => Announcement::where('user_id', Auth::id())->active()->notExpired()->count(),
            'expired' => Announcement::where('user_id', Auth::id())->where('expiry_date', '<', now()->toDateString())->count(),
            'views' => Announcement::where('user_id', Auth::id())->sum('views'),
        ];

        $viewData = [
            'meta_title' => 'Announcements | Nsuk Document Management System',
            'meta_desc' => 'Manage announcements and notifications',
            'meta_image' => url('logo.png'),
            'announcements' => $announcements,
            'stats' => $stats,
            'currentCategory' => $request->category,
            'currentVisibility' => $request->visibility,
            'currentStatus' => $request->status,
            'currentSearch' => $request->search,
        ];

        return view('staff.announcements', $viewData);
    }

    public function createAnnouncement()
    {
        $viewData = [
            'meta_title' => 'Create Announcement | Nsuk Document Management System',
            'meta_desc' => 'Create a new announcement',
            'meta_image' => url('logo.png'),
        ];

        return view('staff.announcements-create', $viewData);
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

            return redirect()->route('staff.announcements')->with('success', 'Announcement created successfully!');

        } catch (\Exception $e) {
            Log::error('Announcement creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to create announcement. Please try again.'])->withInput();
        }
    }

    public function editAnnouncement(Announcement $announcement)
    {
        // Ensure user can only edit their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $viewData = [
            'meta_title' => 'Edit Announcement | Nsuk Document Management System',
            'meta_desc' => 'Edit announcement details',
            'meta_image' => url('logo.png'),
            'announcement' => $announcement,
        ];

        return view('staff.announcements-edit', $viewData);
    }

public function updateAnnouncement(Request $request, Announcement $announcement)
{
    // Admin can update any announcement - no ownership check needed
    $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'category' => 'required|in:general,academic,exam,timetable,memo,other',
        'visibility' => 'required|in:public,staff,student',
        'target_department' => 'nullable|string|max:255',
        'expiry_date' => 'nullable|date|after:today',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:5120', // 5MB max
    ]);

    try {
        $announcementData = [
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'visibility' => $request->visibility,
            'target_department' => $request->target_department,
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
        // Ensure user can only delete their own announcements
        if ($announcement->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete attachment if exists
            if ($announcement->attachment && Storage::disk('public')->exists($announcement->attachment)) {
                Storage::disk('public')->delete($announcement->attachment);
            }

            $announcement->delete();

            return redirect()->route('staff.announcements')->with('success', 'Announcement deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Announcement deletion failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete announcement. Please try again.']);
        }
    }

    public function downloadAnnouncementAttachment(Announcement $announcement)
    {
        if (!$announcement->attachment || !Storage::disk('public')->exists($announcement->attachment)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('public')->download($announcement->attachment, $announcement->attachment_filename);
    }





public function showFeedback(Feedback $feedback)
{
    // Mark as read if not already read
    if (!$feedback->is_read) {
        $feedback->markAsRead();
    }

    $viewData = [
        'meta_title' => 'Feedback Details | Nsuk Document Management System',
        'meta_desc' => 'View and respond to student feedback',
        'meta_image' => url('logo.png'),
        'feedback' => $feedback->load(['user', 'staff']),
    ];

    return view('staff.feedback-details', $viewData);
}


 public function showFeedbacks(Request $request)
    {
        $query = Feedback::with(['user', 'staff'])
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
                $query->where('staff_id', Auth::id());
            } elseif ($request->assigned === 'unassigned') {
                $query->whereNull('staff_id');
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

        // Statistics
        $stats = [
            'total' => Feedback::count(),
            'pending' => Feedback::pending()->count(),
            'in_review' => Feedback::inReview()->count(),
            'resolved' => Feedback::resolved()->count(),
            'unread' => Feedback::unread()->count(),
            'assigned_to_me' => Feedback::where('staff_id', Auth::id())->count(),
        ];

        $viewData = [
            'meta_title' => 'Feedbacks | Nsuk Document Management System',
            'meta_desc' => 'Manage student feedbacks and responses',
            'meta_image' => url('logo.png'),
            'feedbacks' => $feedbacks,
            'stats' => $stats,
            'currentStatus' => $request->status,
            'currentPriority' => $request->priority,
            'currentAssigned' => $request->assigned,
            'currentRead' => $request->read,
            'currentSearch' => $request->search,
        ];

        return view('staff.feedbacks', $viewData);
    }

    public function getFeedbackDetails(Feedback $feedback)
    {
        try {
            // Mark as read if not already read
            if (!$feedback->is_read) {
                $feedback->markAsRead();
            }

            $feedback->load(['user', 'staff']);

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
                    'staff_id' => $feedback->staff_id,
                    'user' => [
                        'name' => $feedback->user->name,
                        'email' => $feedback->user->email,
                    ],
                    'staff' => $feedback->staff ? [
                        'name' => $feedback->staff->name,
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
        $request->validate([
            'action' => 'required|in:assign_to_me,unassign',
        ]);

        try {
            if ($request->action === 'assign_to_me') {
                $feedback->assignToStaff(Auth::id());
                $message = 'Feedback assigned to you successfully!';
            } else {
                $feedback->update([
                    'staff_id' => null,
                    'status' => 'pending'
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
                return response()->json(['success' => false, 'message' => 'Failed to update assignment.'], 500);
            }
            
            return back()->withErrors(['error' => 'Failed to update assignment. Please try again.']);
        }
    }

    public function replyFeedback(Request $request, Feedback $feedback)
    {
        $request->validate([
            'reply' => 'required|string|min:10',
        ]);

        try {
            $feedback->addReply($request->reply, Auth::id());

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
        $request->validate([
            'status' => 'required|in:pending,in_review,resolved',
            'priority' => 'sometimes|in:1,2,3',
        ]);

        try {
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
        if (!$feedback->attachment || !Storage::disk('public')->exists($feedback->attachment)) {
            abort(404, 'Attachment not found.');
        }

        return Storage::disk('public')->download($feedback->attachment, $feedback->attachment_filename);
    }
}