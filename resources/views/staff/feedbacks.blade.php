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

    .feedbacks-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .feedbacks-wrapper {
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
        color: #fff;
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
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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
    .stat-icon.yellow { background: #fef3c7; color: #d97706; }
    .stat-icon.green { background: #d1fae5; color: #059669; }
    .stat-icon.purple { background: #e9d5ff; color: #7c3aed; }
    .stat-icon.red { background: #fee2e2; color: #dc2626; }
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

    .feedbacks-list {
        padding: 1.5rem;
    }

    .feedback-item {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        overflow: hidden;
        cursor: pointer;
    }

    .feedback-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .feedback-item.unread {
        border-left: 4px solid #3b82f6;
        background: #f8fafc;
    }

    .feedback-header {
        padding: 1rem 1.5rem;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .feedback-title {
        font-weight: 600;
        color: #111827;
        margin: 0;
        font-size: 1.125rem;
        flex: 1;
    }

    .feedback-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #6b7280;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    .feedback-body {
        padding: 1.5rem;
    }

    .feedback-content {
        color: #374151;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .feedback-actions {
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-in-review {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-resolved {
        background: #d1fae5;
        color: #065f46;
    }

    .priority-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .priority-low {
        background: #f3f4f6;
        color: #6b7280;
    }

    .priority-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .priority-high {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-primary {
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

    .btn-primary:hover {
        background: #2563eb;
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
        font-size: 0.875rem;
    }

    .btn-success:hover {
        background: #059669;
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
        font-size: 0.875rem;
    }

    .btn-danger:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .attachment-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 8px;
        margin-top: 1rem;
        font-size: 0.875rem;
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

    .unread-indicator {
        width: 8px;
        height: 8px;
        background: #3b82f6;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.5rem;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        max-width: 800px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: #111827;
        flex: 1;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
        padding: 0.5rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .close-modal:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .modal-body {
        padding: 2rem;
    }

    .feedback-details {
        margin-bottom: 2rem;
    }

    .detail-row {
        display: flex;
        margin-bottom: 1rem;
        align-items: flex-start;
        gap: 1rem;
    }

    .detail-label {
        font-weight: 600;
        color: #374151;
        min-width: 120px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        flex: 1;
        color: #6b7280;
    }

    .message-content {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #3b82f6;
        margin: 1.5rem 0;
    }

    .reply-section {
        background: #f0f9ff;
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #10b981;
        margin: 1.5rem 0;
    }

    .reply-form {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: white;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-control.textarea {
        min-height: 120px;
        resize: vertical;
    }

    .modal-actions {
        padding: 1.5rem 2rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .action-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .loading {
        display: none;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .spinner {
        width: 16px;
        height: 16px;
        border: 2px solid #e5e7eb;
        border-top: 2px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .hidden {
        display: none !important;
    }

    @media (max-width: 768px) {
        .content-layout {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .feedback-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .feedback-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .modal-content {
            width: 95%;
            margin: 1rem;
        }

        .modal-header {
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-actions {
            padding: 1rem 1.5rem;
            flex-direction: column;
            align-items: stretch;
        }

        .action-group {
            justify-content: center;
        }

        .detail-row {
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-label {
            min-width: auto;
        }
    }
</style>

<div class="feedbacks-container">
    <div class="feedbacks-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-comments" style="font-size: 2rem;"></i>
                    <h1>Student Feedbacks</h1>
                </div>
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
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Feedbacks</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon yellow">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['pending'] }}</h3>
                    <p>Pending</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['in_review'] }}</h3>
                    <p>In Review</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['resolved'] }}</h3>
                    <p>Resolved</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon red">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['unread'] }}</h3>
                    <p>Unread</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['assigned_to_me'] }}</h3>
                    <p>Assigned to Me</p>
                </div>
            </div>
        </div>

        <div class="content-layout">
            <!-- Main Content -->
            <div class="main-content">
                <div class="content-header">
                    <h2>
                        <i class="fas fa-list"></i>
                        Feedback Management
                    </h2>
                    
                    <!-- Filters -->
                    <form method="GET" class="filters">
                        <select name="status" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="pending" {{ ($currentStatus ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_review" {{ ($currentStatus ?? '') == 'in_review' ? 'selected' : '' }}>In Review</option>
                            <option value="resolved" {{ ($currentStatus ?? '') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        </select>
                        
                        <select name="priority" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Priority</option>
                            <option value="3" {{ ($currentPriority ?? '') == '3' ? 'selected' : '' }}>High</option>
                            <option value="2" {{ ($currentPriority ?? '') == '2' ? 'selected' : '' }}>Medium</option>
                            <option value="1" {{ ($currentPriority ?? '') == '1' ? 'selected' : '' }}>Low</option>
                        </select>
                        
                        <select name="assigned" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Assignment</option>
                            <option value="me" {{ ($currentAssigned ?? '') == 'me' ? 'selected' : '' }}>Assigned to Me</option>
                            <option value="unassigned" {{ ($currentAssigned ?? '') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                        </select>
                        
                        <select name="read" class="filter-select" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="unread" {{ ($currentRead ?? '') == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ ($currentRead ?? '') == 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                        
                        <input type="text" name="search" class="search-box" placeholder="Search feedbacks..." 
                               value="{{ $currentSearch ?? '' }}" onchange="this.form.submit()">
                    </form>
                </div>

                <div class="feedbacks-list">
                    @forelse($feedbacks as $feedback)
                        <div class="feedback-item {{ !$feedback->is_read ? 'unread' : '' }}" 
                             onclick="openFeedbackModal('{{ $feedback->id }}')">
                            <div class="feedback-header">
                                <div style="flex: 1;">
                                    <h3 class="feedback-title">
                                        @if(!$feedback->is_read)
                                            <span class="unread-indicator"></span>
                                        @endif
                                        {{ $feedback->subject }}
                                    </h3>
                                    <div class="feedback-meta">
                                        <span><i class="fas fa-user"></i> {{ $feedback->user->name }}</span>
                                        <span class="status-badge {{ $feedback->status_badge_class }}">
                                            <i class="fas fa-circle" style="font-size: 8px;"></i>
                                            {{ $feedback->status_display }}
                                        </span>
                                        <span class="priority-badge {{ $feedback->priority_badge_class }}">
                                            {{ $feedback->priority_display }} Priority
                                        </span>
                                        <span><i class="fas fa-clock"></i> {{ $feedback->time_since_submission }}</span>
                                        @if($feedback->staff)
                                            <span><i class="fas fa-user-tie"></i> {{ $feedback->staff->name }}</span>
                                        @endif
                                        @if($feedback->attachment)
                                            <span><i class="fas fa-paperclip"></i> Has Attachment</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="feedback-actions" onclick="event.stopPropagation()">
                                    <button onclick="openFeedbackModal('{{ $feedback->id }}')" class="btn-primary" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="feedback-body">
                                <div class="feedback-content">
                                    {{ Str::limit($feedback->message, 200) }}
                                    @if(strlen($feedback->message) > 200)
                                        <button onclick="openFeedbackModal('{{ $feedback->id }}')" style="color: #3b82f6; background: none; border: none; cursor: pointer;">Read more...</button>
                                    @endif
                                </div>
                                
                                @if($feedback->has_reply)
                                    <div style="background: #f0f9ff; padding: 1rem; border-radius: 8px; margin-top: 1rem; border-left: 4px solid #3b82f6;">
                                        <h5 style="margin: 0 0 0.5rem 0; color: #1e40af; font-size: 0.875rem;">
                                            <i class="fas fa-reply"></i> Reply by {{ $feedback->staff->name ?? 'Staff' }}
                                        </h5>
                                        <p style="margin: 0; color: #374151; font-size: 0.875rem;">
                                            {{ Str::limit($feedback->reply, 150) }}
                                        </p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.75rem; color: #6b7280;">
                                            {{ $feedback->replied_at->diffForHumans() }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-comments"></i>
                            <h3>No feedbacks found</h3>
                            <p>No student feedbacks match your current filters.</p>
                        </div>
                    @endforelse
                    
                    <!-- Pagination -->
                    @if($feedbacks->hasPages())
                        <div class="pagination">
                            {{ $feedbacks->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Quick Stats -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-chart-bar"></i> Quick Stats</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><strong>Response Rate:</strong> {{ $stats['total'] > 0 ? round(($stats['resolved'] / $stats['total']) * 100) : 0 }}%</p>
                            <p><strong>Avg Response Time:</strong> 2.5 hours</p>
                            <p><strong>High Priority:</strong> {{ \App\Models\Feedback::byPriority(3)->count() }}</p>
                            <p><strong>This Week:</strong> {{ \App\Models\Feedback::where('created_at', '>=', now()->startOfWeek())->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Priority Guide -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-info-circle"></i> Priority Guide</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><span class="priority-badge priority-high">High</span> Urgent issues, complaints</p>
                            <p><span class="priority-badge priority-medium">Medium</span> General inquiries, requests</p>
                            <p><span class="priority-badge priority-low">Low</span> Suggestions, minor issues</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Feedback Details Modal -->
<div id="feedbackModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Feedback Details</h3>
            <button class="close-modal" onclick="closeFeedbackModal()">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="loading" id="modalLoading">
                <div class="spinner"></div>
                Loading feedback details...
            </div>
            
            <div id="modalContent" class="hidden">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
        
        <div class="modal-actions" id="modalActions" style="display: none;">
            <!-- Actions will be loaded dynamically -->
        </div>
    </div>
</div>

<script>
    let currentFeedbackId = null;

    // Ensure CSRF token is available
    function getCSRFToken() {
        const token = document.querySelector('meta[name="csrf-token"]');
        return token ? token.getAttribute('content') : '';
    }

    // Modal functions
    function openFeedbackModal(feedbackId) {
        currentFeedbackId = feedbackId;
        const modal = document.getElementById('feedbackModal');
        const loading = document.getElementById('modalLoading');
        const content = document.getElementById('modalContent');
        const actions = document.getElementById('modalActions');
        
        // Show modal and loading state
        modal.classList.add('show');
        loading.style.display = 'flex';
        content.classList.add('hidden');
        actions.style.display = 'none';
        
        // Fetch feedback details
        fetch(`/staff/feedbacks/${feedbackId}/details`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                loadFeedbackContent(data.feedback);
                loading.style.display = 'none';
                content.classList.remove('hidden');
                actions.style.display = 'flex';
            } else {
                throw new Error(data.message || 'Failed to load feedback');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loading.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Failed to load feedback details: ' + error.message;
            setTimeout(() => closeFeedbackModal(), 3000);
        });
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').classList.remove('show');
        currentFeedbackId = null;
    }

    function loadFeedbackContent(feedback) {
        const modalTitle = document.getElementById('modalTitle');
        const modalContent = document.getElementById('modalContent');
        const modalActions = document.getElementById('modalActions');
        
        modalTitle.textContent = feedback.subject;
        
        // Build content HTML
        let contentHTML = `
            <div class="feedback-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user"></i> Student:</span>
                    <span class="detail-value">${feedback.user.name}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
                    <span class="detail-value">${feedback.user.email}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-tag"></i> Status:</span>
                    <span class="detail-value">
                        <span class="status-badge ${feedback.status_badge_class}">
                            <i class="fas fa-circle" style="font-size: 8px;"></i>
                            ${feedback.status_display}
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-flag"></i> Priority:</span>
                    <span class="detail-value">
                        <span class="priority-badge ${feedback.priority_badge_class}">
                            ${feedback.priority_display} Priority
                        </span>
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-clock"></i> Submitted:</span>
                    <span class="detail-value">${feedback.time_since_submission}</span>
                </div>
                ${feedback.staff ? `
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-user-tie"></i> Assigned to:</span>
                    <span class="detail-value">${feedback.staff.name}</span>
                </div>
                ` : ''}
            </div>
            
            <div class="message-content">
                <h4 style="margin: 0 0 1rem 0; color: #374151;"><i class="fas fa-comment"></i> Message</h4>
                <p style="margin: 0; white-space: pre-wrap;">${feedback.message}</p>
            </div>
            
            ${feedback.attachment ? `
            <div class="attachment-info">
                <i class="fas fa-paperclip"></i>
                <span>${feedback.attachment_filename}</span>
                <a href="/staff/feedbacks/${feedback.id}/download" class="btn-secondary" style="margin-left: auto;">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
            ` : ''}
            
            ${feedback.has_reply ? `
            <div class="reply-section">
                <h4 style="margin: 0 0 1rem 0; color: #059669;"><i class="fas fa-reply"></i> Reply</h4>
                <p style="margin: 0 0 1rem 0; white-space: pre-wrap;">${feedback.reply}</p>
                <p style="margin: 0; font-size: 0.875rem; color: #6b7280;">
                    Replied by ${feedback.staff ? feedback.staff.name : 'Staff'} • ${feedback.replied_at_human}
                </p>
            </div>
            ` : `
            <form class="reply-form" onsubmit="submitReply(event)">
                <div class="form-group">
                    <label class="form-label"><i class="fas fa-reply"></i> Reply to Student</label>
                    <textarea name="reply" class="form-control textarea" placeholder="Type your reply here..." required></textarea>
                </div>
            </form>
            `}
        `;
        
        modalContent.innerHTML = contentHTML;
        
        // Build actions HTML
        let actionsHTML = `
            <div class="action-group">
                ${!feedback.staff_id || feedback.staff_id !== '{{ Auth::id() }}' ? `
                <form onsubmit="assignFeedback(event)" style="display: inline;">
                    <input type="hidden" name="action" value="assign_to_me">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-user-plus"></i> Assign to Me
                    </button>
                </form>
                ` : `
                <form onsubmit="assignFeedback(event)" style="display: inline;">
                    <input type="hidden" name="action" value="unassign">
                    <button type="submit" class="btn-secondary">
                        <i class="fas fa-user-minus"></i> Unassign
                    </button>
                </form>
                `}
                
                <select onchange="updateStatus(this.value)" class="filter-select">
                    <option value="">Change Status</option>
                    <option value="pending" ${feedback.status === 'pending' ? 'selected' : ''}>Pending</option>
                    <option value="in_review" ${feedback.status === 'in_review' ? 'selected' : ''}>In Review</option>
                    <option value="resolved" ${feedback.status === 'resolved' ? 'selected' : ''}>Resolved</option>
                </select>
            </div>
            
            <div class="action-group">
                ${!feedback.has_reply ? `
                <button type="submit" form="replyForm" class="btn-success">
                    <i class="fas fa-paper-plane"></i> Send Reply
                </button>
                ` : ''}
                <button onclick="closeFeedbackModal()" class="btn-secondary">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        `;
        
        modalActions.innerHTML = actionsHTML;
        
        // Add form ID to reply form if it exists
        const replyForm = modalContent.querySelector('.reply-form');
        if (replyForm) {
            replyForm.id = 'replyForm';
        }
    }

    function submitReply(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const submitBtn = modalActions.querySelector('.btn-success');
        
        // Show loading state
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = '<div class="spinner"></div> Sending...';
        submitBtn.disabled = true;
        
        fetch(`/staff/feedbacks/${currentFeedbackId}/reply`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh page to show updated data
            } else {
                throw new Error(data.message || 'Failed to send reply');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to send reply: ' + error.message);
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
        });
    }

    function assignFeedback(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalHTML = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.innerHTML = '<div class="spinner"></div> Processing...';
        submitBtn.disabled = true;
        
        fetch(`/staff/feedbacks/${currentFeedbackId}/assign`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh page to show updated data
            } else {
                throw new Error(data.message || 'Failed to update assignment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update assignment: ' + error.message);
            submitBtn.innerHTML = originalHTML;
            submitBtn.disabled = false;
        });
    }

    function updateStatus(status) {
        if (!status) return;
        
        const formData = new FormData();
        formData.append('status', status);
        
        fetch(`/staff/feedbacks/${currentFeedbackId}/status`, {
            method: 'PATCH',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload(); // Refresh page to show updated data
            } else {
                throw new Error(data.message || 'Failed to update status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to update status: ' + error.message);
        });
    }

    // Close modal when clicking outside
    document.getElementById('feedbackModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeFeedbackModal();
        }
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