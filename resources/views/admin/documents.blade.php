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

    .documents-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .documents-wrapper {
        max-width: 1400px;
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
        color:#fff;
    }

    .btn-primary {
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

    .btn-primary:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
    }

    .btn-success {
        background: #10b981;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-info {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-info:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: #ef4444;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-danger:hover {
        background: #dc2626;
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

    .alert-success {
        background: #d1fae5;
        border-left: 4px solid #10b981;
        color: #065f46;
    }

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #7f1d1d;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.blue { background: #dbeafe; color: #1d4ed8; }
    .stat-icon.green { background: #d1fae5; color: #059669; }
    .stat-icon.purple { background: #e9d5ff; color: #7c3aed; }
    .stat-icon.orange { background: #fed7aa; color: #ea580c; }

    .stat-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: #111827;
    }

    .stat-content p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .content-layout {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 2rem;
    }

    .main-content {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .content-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .content-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .filters {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        background: white;
    }

    .search-box {
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
        width: 200px;
    }

    .documents-list {
        padding: 1.5rem;
    }

    .document-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .document-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .document-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .document-icon.pdf { background: #fee2e2; color: #dc2626; }
    .document-icon.doc { background: #dbeafe; color: #2563eb; }
    .document-icon.image { background: #d1fae5; color: #059669; }
    .document-icon.other { background: #f3f4f6; color: #6b7280; }

    .document-info {
        flex: 1;
        min-width: 0;
    }

    .document-title {
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .document-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .document-actions {
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .staff-badge {
        background: #f3f4f6;
        color: #374151;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .sidebar-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .sidebar-header h3 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-content {
        padding: 1.5rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
        font-size: 0.875rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 0.875rem;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-area:hover {
        border-color: #4f46e5;
        background: #f8fafc;
    }

    .file-upload-area.dragover {
        border-color: #4f46e5;
        background: #f0f9ff;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-content.large {
        max-width: 800px;
        max-height: 95vh;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
    }

    .document-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-value {
        font-size: 0.875rem;
        color: #111827;
    }

    .document-preview {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        background: #f9fafb;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .preview-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .delete-warning {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .delete-warning h4 {
        color: #dc2626;
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        font-weight: 600;
    }

    .delete-warning p {
        color: #7f1d1d;
        margin: 0;
        font-size: 0.875rem;
    }

    .hidden {
        display: none !important;
    }

    .text-error {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .content-layout {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .document-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .document-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .document-details {
            grid-template-columns: 1fr;
        }

        .modal-content.large {
            max-width: 95%;
        }
    }
</style>

<div class="documents-container">
    <div class="documents-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-file-alt" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff">All Documents Management</h1>
                </div>
                <button id="uploadBtn" class="btn-primary">
                    <i class="fas fa-plus"></i>Upload Document
                </button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle text-xl"></i>
                <div>
                    <p style="margin: 0; font-weight: 600;">{{ session('success') }}</p>
                </div>
            </div>
        @endif

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

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <p>Total Documents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['public'] ?? 0 }}</h3>
                    <p>Public Documents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-eye-slash"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['private'] ?? 0 }}</h3>
                    <p>Private Documents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-download"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['downloads'] ?? 0 }}</h3>
                    <p>Total Downloads</p>
                </div>
            </div>
        </div>

        <div class="content-layout">
            <!-- Main Content -->
            <div class="main-content">
                <div class="content-header">
                    <h2>
                        <i class="fas fa-list"></i>
                        All Documents
                    </h2>
                    
                    <!-- Filters -->
                    <form method="GET" class="filters">
                        <select name="staff" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Staff</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}" {{ ($currentStaff ?? '') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <option value="lecture" {{ ($currentCategory ?? '') == 'lecture' ? 'selected' : '' }}>Lecture</option>
                            <option value="timetable" {{ ($currentCategory ?? '') == 'timetable' ? 'selected' : '' }}>Timetable</option>
                            <option value="memo" {{ ($currentCategory ?? '') == 'memo' ? 'selected' : '' }}>Memo</option>
                            <option value="other" {{ ($currentCategory ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        
                        <select name="visibility" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Visibility</option>
                            <option value="public" {{ ($currentVisibility ?? '') == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="private" {{ ($currentVisibility ?? '') == 'private' ? 'selected' : '' }}>Private</option>
                        </select>
                        
                        <input type="text" name="search" class="search-box" placeholder="Search documents..." 
                               value="{{ $currentSearch ?? '' }}" onchange="this.form.submit()">
                    </form>
                </div>

                <div class="documents-list">
                    @forelse($documents ?? [] as $document)
                        <div class="document-item">
                            <div class="document-icon {{ getFileTypeClass($document->file_extension ?? '') }}">
                                <i class="fas {{ getFileIcon($document->file_extension ?? '') }}"></i>
                            </div>
                            
                            <div class="document-info">
                                <h4 class="document-title">{{ $document->title }}</h4>
                                <div class="document-meta">
                                    <span class="staff-badge">
                                        <i class="fas fa-user"></i> {{ $document->user->name ?? 'Unknown' }}
                                    </span>
                                    <span><i class="fas fa-tag"></i> {{ ucfirst($document->category) }}</span>
                                    <span><i class="fas fa-{{ $document->visibility == 'public' ? 'eye' : 'eye-slash' }}"></i> {{ ucfirst($document->visibility) }}</span>
                                    <span><i class="fas fa-download"></i> {{ $document->downloads ?? 0 }} downloads</span>
                                    <span><i class="fas fa-clock"></i> {{ $document->created_at->diffForHumans() }}</span>
                                    <span><i class="fas fa-hdd"></i> {{ $document->file_size ?? 'Unknown' }}</span>
                                </div>
                                @if($document->description)
                                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #6b7280;">{{ Str::limit($document->description, 100) }}</p>
                                @endif
                            </div>
                            
                            <div class="document-actions">
                                <button onclick="viewDocument('{{ $document->id }}', '{{ addslashes($document->title) }}', '{{ addslashes($document->description ?? '') }}', '{{ $document->category }}', '{{ $document->visibility }}', '{{ $document->downloads ?? 0 }}', '{{ $document->created_at->format('Y-m-d') }}', '{{ $document->file_size ?? 'Unknown' }}', '{{ $document->original_filename ?? $document->title }}', '{{ $document->user->name ?? 'Unknown' }}')" class="btn-info" title="View Document">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <a href="{{ route('admin.documents.download', $document) }}" class="btn-secondary" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                <a href="{{ route('admin.documents.edit', $document) }}" class="btn-success" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete('{{ $document->id }}', '{{ addslashes($document->title) }}')" class="btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
                            <h3>No documents found</h3>
                            <p>Upload your first document to get started.</p>
                            <button onclick="document.getElementById('uploadBtn').click()" class="btn-primary" style="background: darkgreen; margin-top: 1rem;">
                                <i class="fas fa-plus"></i>Upload Document
                            </button>
                        </div>
                    @endforelse
                    
                    <!-- Pagination -->
                    @if(isset($documents) && $documents->hasPages())
                        <div class="pagination">
                            {{ $documents->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Quick Actions -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="sidebar-content">
                        <button id="uploadBtn2" class="btn-primary" style="width: 100%; margin-bottom: 1rem; background: darkgreen;">
                            <i class="fas fa-plus"></i>Upload Document
                        </button>
                        <a href="{{ route('admin.documents') }}" class="btn-secondary" style="width: 100%; justify-content: center;">
                            <i class="fas fa-refresh"></i>Refresh List
                        </a>
                    </div>
                </div>

                <!-- File Types Info -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-info-circle"></i> Supported Files</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><strong>Documents:</strong> PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT</p>
                            <p><strong>Images:</strong> JPG, JPEG, PNG, GIF</p>
                            <p><strong>Max Size:</strong> 10MB per file</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Info -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-shield-alt"></i> Admin Privileges</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><i class="fas fa-check text-green-600"></i> View all documents</p>
                            <p><i class="fas fa-check text-green-600"></i> Edit any document</p>
                            <p><i class="fas fa-check text-green-600"></i> Delete any document</p>
                            <p><i class="fas fa-check text-green-600"></i> Download any document</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-upload"></i> Upload Document</h3>
            <button class="close-modal" onclick="closeModal('uploadModal')">&times;</button>
        </div>
        
        <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Document Title *</label>
                <input type="text" name="title" class="form-control" required 
                       placeholder="Enter document title" value="{{ old('title') }}">
                @error('title')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" 
                          placeholder="Optional description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="lecture" {{ old('category') == 'lecture' ? 'selected' : '' }}>Lecture</option>
                    <option value="timetable" {{ old('category') == 'timetable' ? 'selected' : '' }}>Timetable</option>
                    <option value="memo" {{ old('category') == 'memo' ? 'selected' : '' }}>Memo</option>
                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('category')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">Visibility *</label>
                <select name="visibility" class="form-control" required>
                    <option value="">Select Visibility</option>
                    <option value="public" {{ old('visibility') == 'public' ? 'selected' : '' }}>Public (Everyone can see)</option>
                    <option value="private" {{ old('visibility') == 'private' ? 'selected' : '' }}>Private (Only you can see)</option>
                </select>
                @error('visibility')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            
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
                <label class="form-label">File *</label>
                <div class="file-upload-area" onclick="document.getElementById('fileInput').click()">
                    <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280; margin-bottom: 0.5rem;"></i>
                    <p style="margin: 0; color: #6b7280;">Click to select file or drag and drop</p>
                    <p style="margin: 0; font-size: 0.75rem; color: #9ca3af;">Max size: 10MB</p>
                </div>
                <input type="file" id="fileInput" name="file" class="hidden" required 
                       accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.jpg,.jpeg,.png,.gif">
                <div id="fileName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                @error('file')
                    <p class="text-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                <button type="button" onclick="closeModal('uploadModal')" class="btn-secondary">
                    <i class="fas fa-times"></i>Cancel
                </button>
                <button type="submit" class="btn-success">
                    <i class="fas fa-upload"></i>Upload Document
                </button>
            </div>
        </form>
    </div>
</div>

<!-- View Document Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content large">
        <div class="modal-header">
            <h3><i class="fas fa-eye"></i> <span id="viewDocumentTitle">Document Details</span></h3>
            <button class="close-modal" onclick="closeModal('viewModal')">&times;</button>
        </div>
        
        <div id="viewDocumentContent">
            <!-- Content will be loaded dynamically -->
        </div>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
            <button id="viewDownloadBtn" class="btn-secondary">
                <i class="fas fa-download"></i>Download
            </button>
            <button id="viewEditBtn" class="btn-success">
                <i class="fas fa-edit"></i>Edit
            </button>
            <button onclick="closeModal('viewModal')" class="btn-info">
                <i class="fas fa-times"></i>Close
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-trash text-red-600"></i> Confirm Delete</h3>
            <button class="close-modal" onclick="closeModal('deleteModal')">&times;</button>
        </div>
        
        <div class="delete-warning">
            <h4><i class="fas fa-exclamation-triangle"></i> Warning!</h4>
            <p>This action cannot be undone. The document and its file will be permanently deleted.</p>
        </div>
        
        <p>Are you sure you want to delete the document:</p>
        <p style="font-weight: 600; color: #111827; margin: 1rem 0;"><span id="deleteDocumentTitle"></span></p>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
            <button onclick="closeModal('deleteModal')" class="btn-secondary">
                <i class="fas fa-times"></i>Cancel
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i>Delete Document
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
    }

    // Upload modal functions
    document.getElementById('uploadBtn').addEventListener('click', () => openModal('uploadModal'));
    document.getElementById('uploadBtn2').addEventListener('click', () => openModal('uploadModal'));

    // View document function
    function viewDocument(documentId, title, description, category, visibility, downloads, createdAt, fileSize, filename, staffName) {
        console.log('Viewing document:', documentId); // Debug log
        
        // Update modal title
        document.getElementById('viewDocumentTitle').textContent = title;

        // Create document details HTML
        const detailsHTML = `
            <div class="document-details">
                <div class="detail-item">
                    <span class="detail-label">Title</span>
                    <span class="detail-value">${title}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Uploaded By</span>
                    <span class="detail-value">
                        <span class="staff-badge">
                            <i class="fas fa-user"></i> ${staffName}
                        </span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Category</span>
                    <span class="detail-value">${category.charAt(0).toUpperCase() + category.slice(1)}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Visibility</span>
                    <span class="detail-value">
                        <i class="fas fa-${visibility === 'public' ? 'eye' : 'eye-slash'}"></i>
                        ${visibility.charAt(0).toUpperCase() + visibility.slice(1)}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">File Size</span>
                    <span class="detail-value">${fileSize}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Downloads</span>
                    <span class="detail-value">${downloads}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Created</span>
                    <span class="detail-value">${new Date(createdAt).toLocaleDateString()}</span>
                </div>
            </div>
            ${description ? `
                <div class="detail-item" style="margin-bottom: 1.5rem;">
                    <span class="detail-label">Description</span>
                    <span class="detail-value">${description}</span>
                </div>
            ` : ''}
            <div class="document-preview">
                <div class="preview-icon">
                    <i class="fas fa-file" style="color: #6b7280;"></i>
                </div>
                <h4>${filename}</h4>
                <p style="color: #6b7280; margin: 0;">Click download to view the full document</p>
            </div>
        `;

        // Update modal content
        document.getElementById('viewDocumentContent').innerHTML = detailsHTML;

        // Update action buttons
        document.getElementById('viewDownloadBtn').onclick = () => {
            window.location.href = `/admin/documents/${documentId}/download`;
        };
        document.getElementById('viewEditBtn').onclick = () => {
            window.location.href = `/admin/documents/${documentId}/edit`;
        };

        // Show modal
        openModal('viewModal');
    }

    // Delete confirmation function
    function confirmDelete(documentId, documentTitle) {
        console.log('Confirming delete for:', documentId, documentTitle); // Debug log
        
        document.getElementById('deleteDocumentTitle').textContent = documentTitle;
        document.getElementById('deleteForm').action = `/admin/documents/${documentId}`;
        openModal('deleteModal');
    }

    // File input handling
    document.getElementById('fileInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const fileNameDiv = document.getElementById('fileName');
        if (fileName) {
            fileNameDiv.textContent = `Selected: ${fileName}`;
            fileNameDiv.style.color = '#059669';
        } else {
            fileNameDiv.textContent = '';
        }
    });

    // Drag and drop functionality
    const uploadArea = document.querySelector('.file-upload-area');
    
    if (uploadArea) {
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
                document.getElementById('fileName').textContent = `Selected: ${files[0].name}`;
                document.getElementById('fileName').style.color = '#059669';
            }
        });
    }

    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this.id);
            }
        });
    });

    // Auto-hide success messages
    setTimeout(function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }
    }, 5000);

    // Show modal if there are validation errors
    @if($errors->any())
        openModal('uploadModal');
    @endif
</script>

@php
    // Helper functions for file icons and classes
    function getFileIcon($extension) {
        $extension = strtolower($extension ?? '');
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
        $extension = strtolower($extension ?? '');
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