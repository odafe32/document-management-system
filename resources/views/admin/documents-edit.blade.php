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

    .edit-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .edit-wrapper {
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

    .current-file {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .file-icon.pdf { background: #fee2e2; color: #dc2626; }
    .file-icon.doc { background: #dbeafe; color: #2563eb; }
    .file-icon.image { background: #d1fae5; color: #059669; }
    .file-icon.other { background: #f3f4f6; color: #6b7280; }

    .file-info h4 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        color: #111827;
    }

    .file-meta {
        font-size: 0.875rem;
        color: #6b7280;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .staff-badge {
        background: #f3f4f6;
        color: #374151;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
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

    .hidden {
        display: none !important;
    }

    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="edit-container">
    <div class="edit-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-edit" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff;">Edit Document</h1>
                </div>
                <a href="{{ route('admin.documents') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Documents
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

        <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Document Details -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Document Details
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-signature text-gray-400"></i>
                            Document Title *
                        </label>
                        <input type="text" name="title" class="form-control @error('title') border-red-500 @enderror" 
                               value="{{ old('title', $document->title) }}" required 
                               placeholder="Enter document title">
                        @error('title')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left text-gray-400"></i>
                            Description
                        </label>
                        <textarea name="description" class="form-control @error('description') border-red-500 @enderror" 
                                  rows="4" placeholder="Optional description">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-tag text-gray-400"></i>
                                Category *
                            </label>
                            <select name="category" class="form-control @error('category') border-red-500 @enderror" required>
                                <option value="">Select Category</option>
                                <option value="lecture" {{ old('category', $document->category) == 'lecture' ? 'selected' : '' }}>Lecture</option>
                                <option value="timetable" {{ old('category', $document->category) == 'timetable' ? 'selected' : '' }}>Timetable</option>
                                <option value="memo" {{ old('category', $document->category) == 'memo' ? 'selected' : '' }}>Memo</option>
                                <option value="other" {{ old('category', $document->category) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('category')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-eye text-gray-400"></i>
                                Visibility *
                            </label>
                            <select name="visibility" class="form-control @error('visibility') border-red-500 @enderror" required>
                                <option value="">Select Visibility</option>
                                <option value="public" {{ old('visibility', $document->visibility) == 'public' ? 'selected' : '' }}>Public (Everyone can see)</option>
                                <option value="private" {{ old('visibility', $document->visibility) == 'private' ? 'selected' : '' }}>Private (Only you can see)</option>
                            </select>
                            @error('visibility')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current File -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-file text-blue-600"></i>
                        Current File
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="current-file">
                        <div class="file-icon {{ getFileTypeClass($document->file_extension) }}">
                            <i class="fas {{ getFileIcon($document->file_extension) }}"></i>
                        </div>
                        <div class="file-info">
                            <h4>{{ $document->original_filename }}</h4>
                            <div class="file-meta">
                                <span class="staff-badge">
                                    <i class="fas fa-user"></i> {{ $document->user->name ?? 'Unknown' }}
                                </span>
                                <span><i class="fas fa-hdd"></i> {{ $document->file_size }}</span>
                                <span><i class="fas fa-download"></i> {{ $document->downloads }} downloads</span>
                                <span><i class="fas fa-clock"></i> Uploaded {{ $document->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div style="margin-left: auto;">
                            <a href="{{ route('admin.documents.download', $document) }}" class="btn-secondary" style="background:#111827
                            ">
                                <i class="fas fa-download"></i>Download
                            </a>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-upload text-gray-400"></i>
                            Replace File (Optional)
                        </label>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                            Leave empty to keep the current file. Upload a new file to replace it.
                        </p>
                        
                        <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280; margin-bottom: 0.5rem;"></i>
                            <p style="margin: 0; color: #6b7280;">Click to select new file or drag and drop</p>
                            <p style="margin: 0; font-size: 0.75rem; color: #9ca3af;">Max size: 10MB</p>
                        </div>
                        <input type="file" id="fileInput" name="file" class="hidden" 
                               accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif">
                        <div id="fileName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                        @error('file')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.documents') }}" class="btn-gray">
                    <i class="fas fa-times"></i>Cancel
                </a>
                <button type="submit" class="btn-success">
                    <i class="fas fa-save"></i>Update Document
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
            fileNameDiv.textContent = `New file selected: ${fileName}`;
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
            document.getElementById('fileName').textContent = `New file selected: ${files[0].name}`;
            document.getElementById('fileName').style.color = '#059669';
            document.getElementById('fileName').style.fontWeight = '500';
        }
    });
</script>

@php
    // Helper functions for file icons and classes
    function getFileIcon($extension) {
        $extension = strtolower($extension);
        switch ($extension) {
            case 'pdf':
                return 'fa-file-pdf';
            case 'doc':
            case 'docx':
                return 'fa-file-word';
            case 'ppt':
            case 'pptx':
                return 'fa-file-powerpoint';
            case 'xls':
            case 'xlsx':
                return 'fa-file-excel';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'fa-file-image';
            case 'txt':
                return 'fa-file-alt';
            default:
                return 'fa-file';
        }
    }

    function getFileTypeClass($extension) {
        $extension = strtolower($extension);
        switch ($extension) {
            case 'pdf':
                return 'pdf';
            case 'doc':
            case 'docx':
            case 'ppt':
            case 'pptx':
            case 'xls':
            case 'xlsx':
            case 'txt':
                return 'doc';
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                return 'image';
            default:
                return 'other';
        }
    }
@endphp
@endsection