@extends('layout.student')

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
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
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

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-grid-full {
        grid-column: 1 / -1;
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
        border-color: #7c3aed;
        background: #f8fafc;
    }

    .file-upload-area.dragover {
        border-color: #7c3aed;
        background: #f0f9ff;
    }

    .priority-options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .priority-option {
        position: relative;
    }

    .priority-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .priority-label {
        display: block;
        padding: 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .priority-option input[type="radio"]:checked + .priority-label {
        border-color: #7c3aed;
        background: #f3f4f6;
        color: #7c3aed;
    }

    .priority-low .priority-label {
        border-color: #d1d5db;
        color: #6b7280;
    }

    .priority-medium .priority-label {
        border-color: #f59e0b;
        color: #f59e0b;
    }

    .priority-high .priority-label {
        border-color: #ef4444;
        color: #ef4444;
    }

    .priority-option input[type="radio"]:checked + .priority-label.priority-low {
        background: #f3f4f6;
        color: #6b7280;
        border-color: #6b7280;
    }

    .priority-option input[type="radio"]:checked + .priority-label.priority-medium {
        background: #fef3c7;
        color: #f59e0b;
        border-color: #f59e0b;
    }

    .priority-option input[type="radio"]:checked + .priority-label.priority-high {
        background: #fee2e2;
        color: #ef4444;
        border-color: #ef4444;
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

    .help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .required {
        color: #ef4444;
    }

    .info-box {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-box h4 {
        margin: 0 0 0.5rem 0;
        color: #1e40af;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-box p {
        margin: 0;
        color: #1e40af;
        font-size: 0.875rem;
        line-height: 1.5;
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

        .priority-options {
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
                    <h1>Submit Feedback</h1>
                </div>
                <a href="{{ route('student.feedbacks') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Feedbacks
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

        <!-- Info Box -->
        <div class="info-box">
            <h4><i class="fas fa-info-circle"></i> How to Submit Effective Feedback</h4>
            <p>
                Please be specific and detailed in your feedback. Include relevant information such as course names, 
                dates, or specific incidents. This helps our team provide you with the best possible assistance.
            </p>
        </div>

        <form action="{{ route('student.feedbacks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-edit text-purple-600"></i>
                        Feedback Details
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-heading text-gray-400"></i>
                            Subject <span class="required">*</span>
                        </label>
                        <input type="text" name="subject" class="form-control @error('subject') error @enderror" 
                               value="{{ old('subject') }}" required 
                               placeholder="Brief description of your feedback">
                        @error('subject')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Provide a clear, concise subject line</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-flag text-gray-400"></i>
                            Priority <span class="required">*</span>
                        </label>
                        <div class="priority-options">
                            <div class="priority-option priority-low">
                                <input type="radio" id="priority_low" name="priority" value="1" 
                                       {{ old('priority') == '1' ? 'checked' : '' }}>
                                <label for="priority_low" class="priority-label">
                                    <i class="fas fa-flag"></i><br>
                                    <strong>Low</strong><br>
                                    <small>General inquiry</small>
                                </label>
                            </div>
                            <div class="priority-option priority-medium">
                                <input type="radio" id="priority_medium" name="priority" value="2" 
                                       {{ old('priority') == '2' || !old('priority') ? 'checked' : '' }}>
                                <label for="priority_medium" class="priority-label">
                                    <i class="fas fa-flag"></i><br>
                                    <strong>Medium</strong><br>
                                    <small>Important issue</small>
                                </label>
                            </div>
                            <div class="priority-option priority-high">
                                <input type="radio" id="priority_high" name="priority" value="3" 
                                       {{ old('priority') == '3' ? 'checked' : '' }}>
                                <label for="priority_high" class="priority-label">
                                    <i class="fas fa-flag"></i><br>
                                    <strong>High</strong><br>
                                    <small>Urgent matter</small>
                                </label>
                            </div>
                        </div>
                        @error('priority')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Select the appropriate priority level for your feedback</p>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-comment text-gray-400"></i>
                            Message <span class="required">*</span>
                        </label>
                        <textarea name="message" class="form-control @error('message') error @enderror" 
                                  rows="6" required 
                                  placeholder="Provide detailed information about your feedback, suggestion, or issue...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        <p class="help-text">Be as specific as possible. Include relevant details, dates, and context.</p>
                    </div>
                </div>
            </div>

            <!-- Attachment -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-paperclip text-purple-600"></i>
                        Attachment (Optional)
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-upload text-gray-400"></i>
                            Attach File (Optional)
                        </label>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                            You can attach screenshots, documents, or other files to support your feedback.
                            (PDF, DOC, DOCX, JPG, PNG, GIF - Max 5MB)
                        </p>
                        
                        <div class="file-upload-area" onclick="document.getElementById('attachment').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #9ca3af; margin-bottom: 1rem;"></i>
                            <p style="margin: 0; font-weight: 500; color: #374151;">Click to select file</p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #6b7280;">or drag and drop</p>
                        </div>
                        
                        <input type="file" id="attachment" name="attachment" class="form-control @error('attachment') error @enderror" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" style="display: none;">
                        
                        @error('attachment')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        
                        <div id="filePreview" class="hidden" style="margin-top: 1rem;">
                            <p style="font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem;">Selected file:</p>
                            <div id="fileName" style="padding: 0.5rem; background: #f3f4f6; border-radius: 6px; font-size: 0.875rem;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('student.feedbacks') }}" class="btn-gray">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-success">
                    <i class="fas fa-paper-plane"></i>
                    Submit Feedback
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload handling
    const fileInput = document.getElementById('attachment');
    const uploadArea = document.querySelector('.file-upload-area');
    const filePreview = document.getElementById('filePreview');
    const fileName = document.getElementById('fileName');

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleFilePreview(file);
        }
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            const allowedTypes = ['.pdf', '.doc', '.docx', '.jpg', '.jpeg', '.png', '.gif'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
            
            if (allowedTypes.includes(fileExtension)) {
                fileInput.files = files;
                handleFilePreview(file);
            } else {
                alert('Please select a valid file type (PDF, DOC, DOCX, JPG, PNG, GIF)');
            }
        }
    });

    function handleFilePreview(file) {
        // Validate file size (5MB = 5120KB)
        if (file.size > 5120 * 1024) {
            alert('File size must be less than 5MB');
            fileInput.value = '';
            return;
        }

        // Show preview
        fileName.textContent = file.name + ' (' + formatFileSize(file.size) + ')';
        filePreview.classList.remove('hidden');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const subject = document.querySelector('input[name="subject"]').value.trim();
        const message = document.querySelector('textarea[name="message"]').value.trim();
        const priority = document.querySelector('input[name="priority"]:checked');

        if (!subject) {
            e.preventDefault();
            alert('Please enter a subject for your feedback.');
            return;
        }

        if (!message) {
            e.preventDefault();
            alert('Please enter your feedback message.');
            return;
        }

        if (!priority) {
            e.preventDefault();
            alert('Please select a priority level.');
            return;
        }

        if (message.length < 10) {
            e.preventDefault();
            alert('Please provide more detailed feedback (at least 10 characters).');
            return;
        }
    });
});
</script>

@endsection