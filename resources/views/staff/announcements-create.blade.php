@extends('layout.staff')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #ffffff;
        color: #2d3748;
        line-height: 1.6;
    }

    .create-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .create-wrapper {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .page-header {
        background: darkgreen;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .page-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .page-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-title h1 {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
        color: #fff;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .card-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-content {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-control.textarea {
        min-height: 150px;
        resize: vertical;
        font-family: inherit;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-top: 0.5rem;
    }

    .file-upload-area:hover {
        border-color: #4f46e5;
        background: #f8fafc;
    }

    .file-upload-area.dragover {
        border-color: #4f46e5;
        background: #f0f9ff;
    }

    .form-actions {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-success {
        background: #10b981;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-gray {
        background: #6b7280;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-gray:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #7f1d1d;
    }

    .text-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: auto;
        margin: 0;
    }

    .help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .hidden {
        display: none !important;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="create-container">
    <div class="create-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-plus" style="font-size: 2rem;"></i>
                    <h1>Create Announcement</h1>
                </div>
                <a href="{{ route('staff.announcements') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Announcements
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle text-xl"></i>
                <div>
                    <h3 style="margin: 0; font-weight: 600;">Please fix the following errors:</h3>
                    <ul style="margin: 0.5rem 0 0 0; list-style: disc; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('staff.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Announcement Details -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Announcement Details
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading text-gray-400"></i>
                            Title *
                        </label>
                        <input type="text" name="title" class="form-control @error('title') border-red-500 @enderror" 
                               value="{{ old('title') }}" required 
                               placeholder="Enter announcement title">
                        @error('title')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left text-gray-400"></i>
                            Content *
                        </label>
                        <textarea name="body" class="form-control textarea @error('body') border-red-500 @enderror" 
                                  required placeholder="Enter announcement content">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Write the full content of your announcement. You can include details, instructions, or any relevant information.</p>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag text-gray-400"></i>
                                Category *
                            </label>
                            <select name="category" class="form-control @error('category') border-red-500 @enderror" required>
                                <option value="">Select Category</option>
                                <option value="general" {{ old('category') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="academic" {{ old('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                                <option value="exam" {{ old('category') == 'exam' ? 'selected' : '' }}>Exam</option>
                                <option value="timetable" {{ old('category') == 'timetable' ? 'selected' : '' }}>Timetable</option>
                                <option value="memo" {{ old('category') == 'memo' ? 'selected' : '' }}>Memo</option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Add this field to your announcement create/edit forms -->
<div class="form-group">
    <label class="form-label">
        <i class="fas fa-building text-gray-400"></i>
        Target Department (Optional)
    </label>
    <select name="target_department" class="form-control @error('target_department') error @enderror">
        <option value="">All Departments</option>
        <option value="computer science" {{ old('target_department', $announcement->target_department ?? '') == 'computer science' ? 'selected' : '' }}>Computer Science</option>
        <option value="mathematics" {{ old('target_department', $announcement->target_department ?? '') == 'mathematics' ? 'selected' : '' }}>Mathematics</option>
        <option value="physics" {{ old('target_department', $announcement->target_department ?? '') == 'physics' ? 'selected' : '' }}>Physics</option>
        <option value="chemistry" {{ old('target_department', $announcement->target_department ?? '') == 'chemistry' ? 'selected' : '' }}>Chemistry</option>
        <option value="biology" {{ old('target_department', $announcement->target_department ?? '') == 'biology' ? 'selected' : '' }}>Biology</option>
        <option value="english" {{ old('target_department', $announcement->target_department ?? '') == 'english' ? 'selected' : '' }}>English</option>
        <option value="history" {{ old('target_department', $announcement->target_department ?? '') == 'history' ? 'selected' : '' }}>History</option>
        <option value="economics" {{ old('target_department', $announcement->target_department ?? '') == 'economics' ? 'selected' : '' }}>Economics</option>
        <!-- Add more departments as needed -->
    </select>
    @error('target_department')
        <p class="text-error">{{ $message }}</p>
    @enderror
    <p class="help-text">Leave empty to show announcement to all departments, or select a specific department</p>
</div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-eye text-gray-400"></i>
                                Visibility *
                            </label>
                            <select name="visibility" class="form-control @error('visibility') border-red-500 @enderror" required>
                                <option value="">Select Visibility</option>
                                <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public (Everyone can see)</option>
                                <option value="staff" {{ old('visibility') == 'staff' ? 'selected' : '' }}>Staff Only</option>
                                <option value="student" {{ old('visibility') == 'student' ? 'selected' : '' }}>Students Only</option>
                            </select>
                            @error('visibility')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar-times text-gray-400"></i>
                            Expiry Date (Optional)
                        </label>
                        <input type="date" name="expiry_date" class="form-control @error('expiry_date') border-red-500 @enderror" 
                               value="{{ old('expiry_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('expiry_date')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Leave empty if the announcement should not expire. If set, the announcement will be automatically hidden after this date.</p>
                    </div>
                    
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active" style="margin: 0; font-weight: normal;">
                            <i class="fas fa-toggle-on text-gray-400"></i>
                            Publish immediately
                        </label>
                    </div>
                    <p class="help-text">Uncheck this if you want to save the announcement as draft.</p>
                </div>
            </div>

            <!-- Attachment -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-paperclip text-blue-600"></i>
                        Attachment (Optional)
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-upload text-gray-400"></i>
                            Attach File
                        </label>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                            You can attach a document, image, or other file to this announcement.
                        </p>
                        
                        <div class="file-upload-area" onclick="document.getElementById('attachmentInput').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280; margin-bottom: 0.5rem;"></i>
                            <p style="margin: 0; color: #6b7280;">Click to select file or drag and drop</p>
                            <p style="margin: 0; font-size: 0.75rem; color: #9ca3af;">Max size: 5MB | Supported: PDF, DOC, DOCX, JPG, PNG, GIF</p>
                        </div>
                        <input type="file" id="attachmentInput" name="attachment" class="hidden" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                        <div id="attachmentName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                        @error('attachment')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('staff.announcements') }}" class="btn-gray">
                    <i class="fas fa-times"></i>Cancel
                </a>
                <button type="submit" class="btn-success">
                    <i class="fas fa-bullhorn"></i>Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // File input handling
    document.getElementById('attachmentInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('attachmentName');
        if (fileName) {
            fileNameDiv.textContent = `Selected: ${fileName}`;
            fileNameDiv.style.color = '#059669';
            fileNameDiv.style.fontWeight = '500';
        } else {
            fileNameDiv.textContent = '';
        }
    });

    // Drag and drop functionality
    const uploadArea = document.querySelector('.file-upload-area');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('attachmentInput').files = files;
            document.getElementById('attachmentName').textContent = `Selected: ${files[0].name}`;
            document.getElementById('attachmentName').style.color = '#059669';
            document.getElementById('attachmentName').style.fontWeight = '500';
        }
    });

    // Set minimum date for expiry date to tomorrow
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowString = tomorrow.toISOString().split('T')[0];
    document.querySelector('input[name="expiry_date"]').setAttribute('min', tomorrowString);
</script>
@endsection