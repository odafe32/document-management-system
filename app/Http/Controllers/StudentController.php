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
    $user = Auth::user();
    
    // Get recent announcements for dashboard
    $recentAnnouncements = Announcement::with('user')
        ->active()
        ->notExpired()
        ->studentVisible()
        ->byDepartment($user->department)
        ->latest()
        ->take(5)
        ->get();

    // Get recent documents for dashboard
    $recentDocuments = Document::with('user')
        ->studentVisible()
        ->byDepartment($user->department)
        ->latest()
        ->take(5)
        ->get();

    $viewData = [
       'meta_title'=> 'Student Dashboard | Nsuk Document Management System',
       'meta_desc'=> 'Departmental Information Management System with document management and announcements',
       'meta_image'=> url('logo.png'),
       'recentAnnouncements' => $recentAnnouncements,
       'recentDocuments' => $recentDocuments,
       'user' => $user,
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

    public function showDocuments(Request $request)
    {
        $user = Auth::user();
        
        // Build query - Students see only public documents relevant to their department
        $query = Document::with('user')
            ->studentVisible() // Only public documents
            ->byDepartment($user->department) // Department-specific filtering
            ->latest();

        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $documents = $query->paginate(10);

        // Statistics - Only for documents visible to this student
        $baseQuery = Document::studentVisible()->byDepartment($user->department);

        $stats = [
            'total' => $baseQuery->count(),
            'department' => $baseQuery->where('target_department', $user->department)->count(),
            'general' => $baseQuery->where(function($q) {
                $q->whereNull('target_department')
                  ->orWhere('target_department', '');
            })->count(),
            'downloads' => $baseQuery->sum('downloads'),
        ];

        $viewData = [
            'meta_title' => 'Department Documents | Nsuk Document Management System',
            'meta_desc' => 'Access department documents and resources',
            'meta_image' => url('logo.png'),
            'pageTitle' => ucfirst($user->department) . ' Department Documents',
            'documents' => $documents,
            'stats' => $stats,
            'currentCategory' => $request->category,
            'currentSearch' => $request->search,
            'userDepartment' => $user->department,
        ];

        return view('student.documents', $viewData);
    }

    public function downloadDocument(Document $document)
    {
        $user = Auth::user();
        
        // Check if student can access this document
        if (!$document->canBeAccessedByStudent($user)) {
            abort(403, 'You do not have permission to access this document.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        // Log the download for analytics
        Log::info('Student downloaded document', [
            'student_id' => $user->id,
            'student_name' => $user->name,
            'document_id' => $document->id,
            'document_title' => $document->title,
            'file_name' => $document->original_filename,
        ]);

        // Increment download count (only once per session to avoid inflating numbers)
        $sessionKey = 'downloaded_document_' . $document->id;
        if (!Session::has($sessionKey)) {
            $document->incrementDownloads();
            Session::put($sessionKey, true);
        }

        // Return file download
        return Storage::disk('public')->download($document->file_path, $document->title . '.' . $document->file_extension);
    }

    public function showAnnouncements(Request $request)
    {
        $user = Auth::user();
        
        // Build query - Students see only announcements relevant to their department
        $query = Announcement::with('user')
            ->active() // Only active announcements
            ->notExpired() // Only non-expired announcements
            ->studentVisible() // Only student/public visible announcements
            ->byDepartment($user->department) // Department-specific filtering
            ->latest();

        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $announcements = $query->paginate(10);

        // Don't increment views here - only increment when viewing individual announcement
        
        // Statistics - Only for announcements visible to this student
        $baseQuery = Announcement::active()
            ->notExpired()
            ->studentVisible()
            ->byDepartment($user->department);

        $stats = [
            'total' => $baseQuery->count(),
            'department' => $baseQuery->where('target_department', $user->department)->count(),
            'general' => $baseQuery->where(function($q) {
                $q->whereNull('target_department')
                  ->orWhere('target_department', '');
            })->count(),
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
        
        // Load the user relationship
        $announcement->load('user');
        
        // Debug information - Log the access attempt
        Log::info('Student attempting to view announcement', [
            'student_id' => $user->id,
            'student_name' => $user->name,
            'student_department' => $user->department,
            'announcement_id' => $announcement->id,
            'announcement_title' => $announcement->title,
            'announcement_visibility' => $announcement->visibility,
            'announcement_target_department' => $announcement->target_department,
            'announcement_is_active' => $announcement->is_active,
            'announcement_expiry_date' => $announcement->expiry_date,
            'announcement_is_expired' => $announcement->is_expired,
        ]);
        
        // Check if student can view this announcement with detailed debugging
        $canView = $this->canStudentAccessAnnouncement($announcement, $user);
        
        if (!$canView) {
            // Log the specific reason for denial
            $reasons = $this->getAccessDenialReasons($announcement, $user);
            Log::warning('Student access denied to announcement', [
                'student_id' => $user->id,
                'announcement_id' => $announcement->id,
                'denial_reasons' => $reasons,
            ]);
            
            // Show detailed error message in development
            if (config('app.debug')) {
                $errorMessage = 'Access denied. Reasons: ' . implode(', ', $reasons);
                abort(403, $errorMessage);
            }
            
            abort(403, 'You do not have permission to view this announcement.');
        }

        // Increment views (only once per session to avoid inflating numbers)
        $sessionKey = 'viewed_announcement_' . $announcement->id;
        if (!Session::has($sessionKey)) {
            $announcement->incrementViews();
            Session::put($sessionKey, true);
        }

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
        $canAccess = $this->canStudentAccessAnnouncement($announcement, $user);
        
        if (!$canAccess) {
            abort(403, 'You do not have permission to access this attachment.');
        }

        if (!$announcement->attachment || !Storage::disk('public')->exists($announcement->attachment)) {
            abort(404, 'Attachment not found.');
        }

        // Log the download for analytics (optional)
        Log::info('Student downloaded announcement attachment', [
            'student_id' => $user->id,
            'student_name' => $user->name,
            'announcement_id' => $announcement->id,
            'announcement_title' => $announcement->title,
            'attachment' => $announcement->attachment_filename,
        ]);

        return Storage::disk('public')->download($announcement->attachment, $announcement->attachment_filename);
    }

    /**
     * Check if a student can access a specific announcement
     */
    private function canStudentAccessAnnouncement(Announcement $announcement, User $user): bool
    {
        // Check visibility - must be student or public
        if (!in_array($announcement->visibility, ['student', 'public'])) {
            return false;
        }

        // Check if announcement is active
        if (!$announcement->is_active) {
            return false;
        }

        // Check if announcement is expired
        if ($announcement->expiry_date && $announcement->expiry_date->isPast()) {
            return false;
        }

        // Check department access - more flexible logic
        if (!empty($announcement->target_department)) {
            // If target_department is set, check if it matches user's department
            // Make comparison case-insensitive and handle potential whitespace
            $targetDept = strtolower(trim($announcement->target_department));
            $userDept = strtolower(trim($user->department ?? ''));
            
            if ($targetDept !== $userDept) {
                return false;
            }
        }
        // If target_department is null or empty, it's a general announcement - allow access

        return true;
    }

    /**
     * Get detailed reasons why access was denied (for debugging)
     */
    private function getAccessDenialReasons(Announcement $announcement, User $user): array
    {
        $reasons = [];

        // Check visibility
        if (!in_array($announcement->visibility, ['student', 'public'])) {
            $reasons[] = "Visibility is '{$announcement->visibility}' (must be 'student' or 'public')";
        }

        // Check if announcement is active
        if (!$announcement->is_active) {
            $reasons[] = "Announcement is not active";
        }

        // Check if announcement is expired
        if ($announcement->expiry_date && $announcement->expiry_date->isPast()) {
            $reasons[] = "Announcement expired on {$announcement->expiry_date->format('Y-m-d')}";
        }

        // Check department access
        if (!empty($announcement->target_department)) {
            $targetDept = strtolower(trim($announcement->target_department));
            $userDept = strtolower(trim($user->department ?? ''));
            
            if ($targetDept !== $userDept) {
                $reasons[] = "Department mismatch: announcement targets '{$announcement->target_department}', user is in '{$user->department}'";
            }
        }

        return $reasons;
    }

    /**
     * Get documents for student dashboard
     */
    public function getDashboardDocuments()
    {
        $user = Auth::user();
        
        return Document::with('user')
            ->studentVisible()
            ->byDepartment($user->department)
            ->latest()
            ->take(3)
            ->get();
    }

    /**
     * Search documents (AJAX endpoint)
     */
    public function searchDocuments(Request $request)
    {
        $user = Auth::user();
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $documents = Document::with('user')
            ->studentVisible()
            ->byDepartment($user->department)
            ->search($query)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($document) {
                return [
                    'id' => $document->id,
                    'title' => $document->title,
                    'description' => Str::limit($document->description, 100),
                    'category' => $document->category_display,
                    'file_size' => $document->file_size,
                    'downloads' => $document->downloads,
                    'url' => route('student.documents.download', $document),
                ];
            });

        return response()->json($documents);
    }

    // Add these methods to your StudentController class

public function showFeedbacks(Request $request)
{
    $user = Auth::user();
    
    // Build query for student's feedbacks
    $query = Feedback::with(['admin', 'staff'])
        ->where('user_id', $user->id)
        ->latest();

    // Apply filters
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('priority')) {
        $query->byPriority($request->priority);
    }

    if ($request->filled('search')) {
        $query->search($request->search);
    }

    $feedbacks = $query->paginate(10);

    // Statistics for student's feedbacks
    $stats = [
        'total' => Feedback::where('user_id', $user->id)->count(),
        'pending' => Feedback::where('user_id', $user->id)->pending()->count(),
        'in_review' => Feedback::where('user_id', $user->id)->inReview()->count(),
        'resolved' => Feedback::where('user_id', $user->id)->resolved()->count(),
    ];

    $viewData = [
        'meta_title' => 'My Feedbacks | Nsuk Document Management System',
        'meta_desc' => 'View and track your submitted feedbacks and responses',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'My Feedbacks',
        'feedbacks' => $feedbacks,
        'stats' => $stats,
        'currentStatus' => $request->status,
        'currentPriority' => $request->priority,
        'currentSearch' => $request->search,
    ];

    return view('student.feedbacks', $viewData);
}

public function createFeedback()
{
    $viewData = [
        'meta_title' => 'Submit Feedback | Nsuk Document Management System',
        'meta_desc' => 'Submit your feedback, suggestions, or report issues',
        'meta_image' => url('logo.png'),
        'pageTitle' => 'Submit New Feedback',
    ];

    return view('student.feedback-create', $viewData);
}

public function storeFeedback(Request $request)
{
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:2000',
        'priority' => 'required|in:1,2,3',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif|max:5120', // 5MB max
    ]);

    try {
        $feedbackData = [
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'priority' => $request->priority,
            'status' => 'pending',
            'is_read' => false,
        ];

        // Handle file attachment
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('feedbacks', $filename, 'public');
            $feedbackData['attachment'] = $path;
        }

        Feedback::create($feedbackData);

        return redirect()->route('student.feedbacks')->with('success', 'Feedback submitted successfully! We will review it and get back to you soon.');

    } catch (\Exception $e) {
        Log::error('Feedback submission failed: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Failed to submit feedback. Please try again.'])->withInput();
    }
}

public function viewFeedback(Feedback $feedback)
{
    $user = Auth::user();
    
    // Ensure the feedback belongs to the current student
    if ($feedback->user_id !== $user->id) {
        abort(403, 'You do not have permission to view this feedback.');
    }

    // Load relationships
    $feedback->load(['admin', 'staff']);

    $viewData = [
        'meta_title' => $feedback->subject . ' | Nsuk Document Management System',
        'meta_desc' => 'View feedback details and response',
        'meta_image' => url('logo.png'),
        'feedback' => $feedback,
    ];

    return view('student.feedback-detail', $viewData);
}

public function downloadFeedbackAttachment(Feedback $feedback)
{
    $user = Auth::user();
    
    // Ensure the feedback belongs to the current student
    if ($feedback->user_id !== $user->id) {
        abort(403, 'You do not have permission to access this attachment.');
    }

    if (!$feedback->attachment || !Storage::disk('public')->exists($feedback->attachment)) {
        abort(404, 'Attachment not found.');
    }

    return Storage::disk('public')->download($feedback->attachment, $feedback->attachment_filename);
}
}