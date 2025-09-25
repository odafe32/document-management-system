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

    .feedbacks-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .feedbacks-wrapper {
        max-width: 1200px;
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
    .stat-icon.yellow { background: #fef3c7; color: #d97706; }
    .stat-icon.purple { background: #e9d5ff; color: #7c3aed; }
    .stat-icon.green { background: #d1fae5; color: #059669; }

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
        background: white;
    }

    .feedback-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .feedback-header {
        padding: 1.5rem;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .feedback-info {
        flex: 1;
    }

    .feedback-title {
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.5rem 0;
        font-size: 1.125rem;
    }

    .feedback-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
        flex-wrap: wrap;
        align-items: center;
    }

    .feedback-badges {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
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

    .feedback-body {
        padding: 1.5rem;
    }

    .feedback-message {
        color: #374151;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .feedback-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .btn-view {
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

    .btn-view:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .reply-indicator {
        background: #d1fae5;
        color: #065f46;
        padding: 0.75rem;
        border-radius: 8px;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
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

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .feedback-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .feedback-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .filters {
            flex-direction: column;
            width: 100%;
        }

        .search-box {
            width: 100%;
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
                    <h1>My Feedbacks</h1>
                </div>
                <a href="{{ route('student.feedbacks.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>Submit New Feedback
                </a>
            </div>
        </div>

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
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>
                    <i class="fas fa-list"></i>
                    Your Feedbacks
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
                        <option value="">All Priorities</option>
                        <option value="1" {{ ($currentPriority ?? '') == '1' ? 'selected' : '' }}>Low</option>
                        <option value="2" {{ ($currentPriority ?? '') == '2' ? 'selected' : '' }}>Medium</option>
                        <option value="3" {{ ($currentPriority ?? '') == '3' ? 'selected' : '' }}>High</option>
                    </select>
                    
                    <input type="text" name="search" class="search-box" placeholder="Search feedbacks..." 
                           value="{{ $currentSearch ?? '' }}" onchange="this.form.submit()">
                </form>
            </div>

            <div class="feedbacks-list">
                @forelse($feedbacks as $feedback)
                    <div class="feedback-item">
                        <div class="feedback-header">
                            <div class="feedback-info">
                                <h3 class="feedback-title">{{ $feedback->subject }}</h3>
                                <div class="feedback-meta">
                                    <span><i class="fas fa-calendar"></i> {{ $feedback->created_at->format('M d, Y \a\t g:i A') }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $feedback->time_since_submission }}</span>
                                    @if($feedback->has_reply)
                                        <span><i class="fas fa-reply"></i> Replied {{ $feedback->replied_at_human }}</span>
                                    @endif
                                    @if($feedback->admin_name)
                                        <span><i class="fas fa-user-tie"></i> Handled by {{ $feedback->admin_name }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="feedback-badges">
                                <span class="status-badge {{ $feedback->status_badge_class }}">
                                    <i class="fas fa-{{ $feedback->status == 'pending' ? 'clock' : ($feedback->status == 'in_review' ? 'eye' : 'check') }}"></i>
                                    {{ $feedback->status_display }}
                                </span>
                                <span class="priority-badge {{ $feedback->priority_badge_class }}">
                                    <i class="fas fa-flag"></i>
                                    {{ $feedback->priority_display }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="feedback-body">
                            <div class="feedback-message">
                                {{ Str::limit($feedback->message, 200) }}
                            </div>
                            
                            @if($feedback->has_reply)
                                <div class="reply-indicator">
                                    <i class="fas fa-reply"></i>
                                    <strong>Admin Reply Available</strong> - Click "View Details" to read the response
                                </div>
                            @endif
                            
                            <div class="feedback-actions">
                                <a href="{{ route('student.feedbacks.view', $feedback) }}" class="btn-view">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-comments"></i>
                        <h3>No feedbacks found</h3>
                        <p>You haven't submitted any feedbacks yet. Click "Submit New Feedback" to get started.</p>
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
    </div>
</div>
@endsection