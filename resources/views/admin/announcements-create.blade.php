@extends('layout.admin')

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

    .form-control.error {
        border-color: #ef4444;
    }

    .form-control.error:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .text-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-top: 1rem;
    }

    .file-upload-area:hover {
        border-color: #4f46e5;
        background: #f8fafc;
    }

    .file-upload-area.dragover {
        border-color: #4f46e5;
        background: #f0f9ff;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        accent-color: #4f46e5;
    }

    .checkbox-label {
        font-weight: 500;
        color: #374151;
        cursor: pointer;
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

    .hidden {
        display: none !important;
    }

    .help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-grid-full {
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="create-container">
    <div class="create-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-plus-circle" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff;">Create Announcement</h1>
                </div>
                <a href="{{ route('admin.announcements') }}" class="btn-secondary">
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

        <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Basic Information
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading text-gray-400"></i>
                            Announcement Title *
                        </label>
                        <input type="text" name="title" class="form-control @error('title') error @enderror" 
                               value="{{ old('title') }}" required 
                               placeholder="Enter announcement title">
                        @error('title')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Choose a clear and descriptive title for your announcement</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left text-gray-400"></i>
                            Announcement Content *
                        </label>
                        <textarea name="body" class="form-control @error('body') error @enderror" 
                                  rows="8" required placeholder="Write your announcement content here...">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Provide detailed information about your announcement</p>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-cog text-blue-600"></i>
                        Announcement Settings
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag text-gray-400"></i>
                                Category *
                            </label>
                            <select name="category" class="form-control @error('category') error @enderror" required>
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
                            <select name="visibility" class="form-control @error('visibility') error @enderror" required>
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
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            Expiry Date (Optional)
                        </label>
                        <input type="date" name="expiry_date" class="form-control @error('expiry_date') error @enderror" 
                               value="{{ old('expiry_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        @error('expiry_date')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Leave empty for no expiry date. Must be a future date.</p>
                    </div>
                    
                    <div class="form-group">
                        <div class="checkbox-group">
                            <input type="checkbox" id="is_active" name="is_active" class="checkbox-input" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="checkbox-label">
                                <i class="fas fa-toggle-on text-green-600"></i>
                                Publish announcement immediately
                            </label>
                        </div>
                        <p class="help-text">Uncheck to save as draft</p>
                    </div>
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
                            You can attach a file to your announcement (PDF, DOC, DOCX, JPG, PNG, GIF - Max 5MB)
                        </p>
                        
                        <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280; margin-bottom: 0.5rem;"></i>
                            <p style="margin: 0; color: #6b7280;">Click to select file or drag and drop</p>
                            <p style="margin: 0; font-size: 0.75rem; color: #9ca3af;">Max size: 5MB</p>
                        </div>
                        <input type="file" id="fileInput" name="attachment" class="hidden" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                        <div id="fileName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                        @error('attachment')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.announcements') }}" class="btn-gray">
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
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('fileName');
        if (fileName) {
            fileNameDiv.textContent = `Selected file: ${fileName}`;
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
            document.getElementById('fileInput').files = files;
            document.getElementById('fileName').textContent = `Selected file: ${files[0].name}`;
            document.getElementById('fileName').style.color = '#059669';
            document.getElementById('fileName').style.fontWeight = '500';
        }
    });

    // Auto-resize textarea
    document.querySelector('textarea[name="body"]').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const title = document.querySelector('input[name="title"]').value.trim();
        const body = document.querySelector('textarea[name="body"]').value.trim();
        const category = document.querySelector('select[name="category"]').value;
        const visibility = document.querySelector('select[name="visibility"]').value;

        if (!title || !body || !category || !visibility) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }

        // Show loading state
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Creating...';
    });
</script>

@endsection