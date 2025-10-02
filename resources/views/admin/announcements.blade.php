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

    .announcements-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .announcements-wrapper {
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

    .announcements-list {
        padding: 1.5rem;
    }

    .announcement-item {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .announcement-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .announcement-header {
        padding: 1rem 1.5rem;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .announcement-title {
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.5rem 0;
        font-size: 1.125rem;
    }

    .announcement-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .announcement-body {
        padding: 1.5rem;
    }

    .announcement-content {
        color: #374151;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .announcement-actions {
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

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-expired {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .category-badge {
        background: #e0e7ff;
        color: #3730a3;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .visibility-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .attachment-info {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .attachment-icon {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e5e7eb;
        color: #6b7280;
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
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
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

    @media (max-width: 768px) {
        .content-layout {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .announcement-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .announcement-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<div class="announcements-container">
    <div class="announcements-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-bullhorn" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff">All Announcements Management</h1>
                </div>
                <a href="{{ route('admin.announcements.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>Create Announcement
                </a>
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
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <p>Total Announcements</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['active'] ?? 0 }}</h3>
                    <p>Active Announcements</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['expired'] ?? 0 }}</h3>
                    <p>Expired Announcements</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['views'] ?? 0 }}</h3>
                    <p>Total Views</p>
                </div>
            </div>
        </div>

        <div class="content-layout">
            <!-- Main Content -->
            <div class="main-content">
                <div class="content-header">
                    <h2>
                        <i class="fas fa-list"></i>
                        All Announcements
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
                            <option value="general" {{ ($currentCategory ?? '') == 'general' ? 'selected' : '' }}>General</option>
                            <option value="academic" {{ ($currentCategory ?? '') == 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="exam" {{ ($currentCategory ?? '') == 'exam' ? 'selected' : '' }}>Exam</option>
                            <option value="timetable" {{ ($currentCategory ?? '') == 'timetable' ? 'selected' : '' }}>Timetable</option>
                            <option value="memo" {{ ($currentCategory ?? '') == 'memo' ? 'selected' : '' }}>Memo</option>
                            <option value="other" {{ ($currentCategory ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>

                        <select name="visibility" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Visibility</option>
                            <option value="public" {{ ($currentVisibility ?? '') == 'public' ? 'selected' : '' }}>Public</option>
                            <option value="staff" {{ ($currentVisibility ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="student" {{ ($currentVisibility ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                        </select>

                        <select name="status" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ ($currentStatus ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="expired" {{ ($currentStatus ?? '') == 'expired' ? 'selected' : '' }}>Expired</option>
                            <option value="inactive" {{ ($currentStatus ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <input type="text" name="search" class="search-box" placeholder="Search announcements..."
                               value="{{ $currentSearch ?? '' }}" onchange="this.form.submit()">
                    </form>
                </div>

                <div class="announcements-list">
                    @forelse($announcements ?? [] as $announcement)
                        <div class="announcement-item">
                            <div class="announcement-header">
                                <div style="flex: 1;">
                                    <h3 class="announcement-title">{{ $announcement->title }}</h3>
                                    <div class="announcement-meta">
                                        <span class="staff-badge">
                                            <i class="fas fa-user"></i> {{ $announcement->user->name ?? 'Unknown' }}
                                        </span>
                                        <span class="category-badge">
                                            <i class="fas fa-tag"></i> {{ $announcement->category_display }}
                                        </span>
                                        <span class="visibility-badge">
                                            <i class="fas fa-eye"></i> {{ $announcement->visibility_display }}
                                        </span>
                                        <span class="status-badge {{ $announcement->status_badge_class }}">
                                            <i class="fas fa-circle"></i> {{ $announcement->status_text }}
                                        </span>
                                        <span><i class="fas fa-eye"></i> {{ $announcement->views ?? 0 }} views</span>
                                        <span><i class="fas fa-clock"></i> {{ $announcement->created_at->diffForHumans() }}</span>
                                        @if($announcement->expiry_date)
                                            <span><i class="fas fa-calendar"></i> Expires {{ $announcement->expiry_date->format('M d, Y') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="announcement-actions">
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn-success" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($announcement->attachment)
                                        <a href="{{ route('admin.announcements.download', $announcement) }}" class="btn-secondary" title="Download Attachment">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @endif
                                    <button onclick="confirmDelete('{{ $announcement->id }}', '{{ addslashes($announcement->title) }}')" class="btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="announcement-body">
                                <div class="announcement-content">
                                    {{ Str::limit(strip_tags($announcement->body), 200) }}
                                </div>

                                @if($announcement->attachment)
                                    <div class="attachment-info">
                                        <div class="attachment-icon">
                                            <i class="fas fa-paperclip"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $announcement->attachment_filename }}</strong>
                                            <br>
                                            <small class="text-gray-500">Attachment available</small>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-bullhorn"></i>
                            <h3>No announcements found</h3>
                            <p>Create your first announcement to get started.</p>
                            <a href="{{ route('admin.announcements.create') }}" class="btn-primary" style="background: darkgreen; margin-top: 1rem;">
                                <i class="fas fa-plus"></i>Create Announcement
                            </a>
                        </div>
                    @endforelse


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
                        <a href="{{ route('admin.announcements.create') }}" class="btn-primary" style="width: 100%; margin-bottom: 1rem; background: darkgreen; justify-content: center;">
                            <i class="fas fa-plus"></i>Create Announcement
                        </a>
                        <a href="{{ route('admin.announcements') }}" class="btn-secondary" style="width: 100%; justify-content: center;">
                            <i class="fas fa-refresh"></i>Refresh List
                        </a>
                    </div>
                </div>

                <!-- Categories Info -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-info-circle"></i> Categories</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><strong>General:</strong> General announcements</p>
                            <p><strong>Academic:</strong> Academic related</p>
                            <p><strong>Exam:</strong> Examination notices</p>
                            <p><strong>Timetable:</strong> Schedule updates</p>
                            <p><strong>Memo:</strong> Official memos</p>
                            <p><strong>Other:</strong> Miscellaneous</p>
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
                            <p><i class="fas fa-check text-green-600"></i> View all announcements</p>
                            <p><i class="fas fa-check text-green-600"></i> Edit any announcement</p>
                            <p><i class="fas fa-check text-green-600"></i> Delete any announcement</p>
                            <p><i class="fas fa-check text-green-600"></i> Download attachments</p>
                        </div>
                    </div>
                </div>
            </div>
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
            <p>This action cannot be undone. The announcement and its attachment will be permanently deleted.</p>
        </div>

        <p>Are you sure you want to delete the announcement:</p>
        <p style="font-weight: 600; color: #111827; margin: 1rem 0;"><span id="deleteAnnouncementTitle"></span></p>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
            <button onclick="closeModal('deleteModal')" class="btn-secondary">
                <i class="fas fa-times"></i>Cancel
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i>Delete Announcement
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

    // Delete confirmation function
    function confirmDelete(announcementId, announcementTitle) {
        console.log('Confirming delete for:', announcementId, announcementTitle); // Debug log

        document.getElementById('deleteAnnouncementTitle').textContent = announcementTitle;
        document.getElementById('deleteForm').action = `/admin/announcements/${announcementId}`;
        openModal('deleteModal');
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
</script>

@endsection
