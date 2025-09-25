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

    .detail-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .detail-wrapper {
        max-width: 900px;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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

    .feedback-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: #f8fafc;
        border-radius: 12px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .meta-item i {
        color: #6b7280;
        width: 16px;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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

    .feedback-content {
        background: #f9fafb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #7c3aed;
    }

    .feedback-content h3 {
        margin: 0 0 1rem 0;
        color: #111827;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .feedback-message {
        color: #374151;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .attachment-section {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .attachment-section h4 {
        margin: 0 0 1rem 0;
        color: #1e40af;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .attachment-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .attachment-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #dbeafe;
        color: #1d4ed8;
        font-size: 1.25rem;
    }

    .attachment-info {
        flex: 1;
    }

    .attachment-name {
        font-weight: 500;
        color: #111827;
        margin: 0;
    }

    .attachment-size {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .btn-download {
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

    .btn-download:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .reply-section {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
        border-left: 4px solid #10b981;
    }

    .reply-section h3 {
        margin: 0 0 1rem 0;
        color: #065f46;
        font-size: 1.125rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reply-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: #059669;
        flex-wrap: wrap;
    }

    .reply-content {
        color: #374151;
        line-height: 1.6;
        white-space: pre-wrap;
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #d1fae5;
    }

    .no-reply {
        background: #fef3c7;
        border: 1px solid #fbbf24;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
        text-align: center;
        color: #92400e;
    }

    .no-reply i {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.7;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0.25rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: #7c3aed;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #7c3aed;
    }

    .timeline-content {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        margin-left: 1rem;
    }

    .timeline-time {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .timeline-text {
        color: #374151;
        margin: 0;
    }

    @media (max-width: 768px) {
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .feedback-meta {
            grid-template-columns: 1fr;
        }

        .attachment-item {
            flex-direction: column;
            text-align: center;
        }

        .reply-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>

<div class="detail-container">
    <div class="detail-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-comment-dots" style="font-size: 2rem;"></i>
                    <h1>Feedback Details</h1>
                </div>
                <a href="{{ route('student.feedbacks') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Feedbacks
                </a>
            </div>
        </div>

        <!-- Feedback Information -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-info-circle text-blue-600"></i>
                    {{ $feedback->subject }}
                </h2>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
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
            <div class="card-content">
                
                <!-- Feedback Meta Information -->
                <div class="feedback-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span><strong>Submitted:</strong> {{ $feedback->created_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-clock"></i>
                        <span><strong>Time Ago:</strong> {{ $feedback->time_since_submission }}</span>
                    </div>
                    @if($feedback->admin_name)
                        <div class="meta-item">
                            <i class="fas fa-user-tie"></i>
                            <span><strong>Handled by:</strong> {{ $feedback->admin_name }}</span>
                        </div>
                    @endif
                    @if($feedback->assigned_at)
                        <div class="meta-item">
                            <i class="fas fa-user-check"></i>
                            <span><strong>Assigned:</strong> {{ $feedback->assigned_at->format('M d, Y \a\t g:i A') }}</span>
                        </div>
                    @endif
                    @if($feedback->response_time)
                        <div class="meta-item">
                            <i class="fas fa-stopwatch"></i>
                            <span><strong>Response Time:</strong> {{ $feedback->response_time }}</span>
                        </div>
                    @endif
                </div>

                <!-- Feedback Content -->
                <div class="feedback-content">
                    <h3><i class="fas fa-comment"></i> Your Feedback</h3>
                    <div class="feedback-message">{{ $feedback->message }}</div>
                </div>

                <!-- Attachment Section -->
                @if($feedback->attachment)
                    <div class="attachment-section">
                        <h4><i class="fas fa-paperclip"></i> Attachment</h4>
                        <div class="attachment-item">
                            <div class="attachment-icon">
                                <i class="fas fa-file"></i>
                            </div>
                            <div class="attachment-info">
                                <p class="attachment-name">{{ $feedback->attachment_filename }}</p>
                                <p class="attachment-size">Click to download</p>
                            </div>
                            <a href="{{ route('student.feedbacks.download', $feedback) }}" class="btn-download">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reply Section -->
        @if($feedback->has_reply)
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-reply text-green-600"></i>
                        Admin Response
                    </h2>
                </div>
                <div class="card-content">
                    <div class="reply-section">
                        <h3><i class="fas fa-user-tie"></i> Response from {{ $feedback->admin_name ?? 'Admin' }}</h3>
                        <div class="reply-meta">
                            <span><i class="fas fa-calendar"></i> {{ $feedback->replied_at->format('M d, Y \a\t g:i A') }}</span>
                            <span><i class="fas fa-clock"></i> {{ $feedback->replied_at_human }}</span>
                        </div>
                        <div class="reply-content">{{ $feedback->reply }}</div>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-content">
                    <div class="no-reply">
                        <i class="fas fa-hourglass-half"></i>
                        <h3>Waiting for Response</h3>
                        <p>Your feedback has been received and is being reviewed. You will be notified when there's a response.</p>
                        @if($feedback->status == 'pending')
                            <p><small>Status: Pending Review</small></p>
                        @elseif($feedback->status == 'in_review')
                            <p><small>Status: Currently Being Reviewed</small></p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Timeline -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-history text-gray-600"></i>
                    Feedback Timeline
                </h2>
            </div>
            <div class="card-content">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="timeline-time">{{ $feedback->created_at->format('M d, Y \a\t g:i A') }}</div>
                            <p class="timeline-text"><strong>Feedback Submitted</strong> - Your feedback was successfully submitted to the system.</p>
                        </div>
                    </div>
                    
                    @if($feedback->assigned_at)
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-time">{{ $feedback->assigned_at->format('M d, Y \a\t g:i A') }}</div>
                                <p class="timeline-text"><strong>Assigned for Review</strong> - Your feedback was assigned to {{ $feedback->admin_name ?? 'an admin' }} for review.</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($feedback->replied_at)
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-time">{{ $feedback->replied_at->format('M d, Y \a\t g:i A') }}</div>
                                <p class="timeline-text"><strong>Response Provided</strong> - {{ $feedback->admin_name ?? 'Admin' }} provided a response to your feedback.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection