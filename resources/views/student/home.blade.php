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

    .home-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .home-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .welcome-header {
        background: darkgreen;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .welcome-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .welcome-content {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }

    .welcome-text {
        flex: 1;
    }

    .welcome-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: #fff;
    }

    .welcome-text p {
        font-size: 1.125rem;
        margin: 0;
        opacity: 0.9;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-details h3 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .user-details p {
        margin: 0;
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-icon.blue { background: #dbeafe; color: #1d4ed8; }
    .stat-icon.green { background: #d1fae5; color: #059669; }
    .stat-icon.purple { background: #e9d5ff; color: #7c3aed; }
    .stat-icon.orange { background: #fed7aa; color: #ea580c; }
    .stat-icon.red { background: #fecaca; color: #dc2626; }

    .stat-content h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        color: #111827;
    }

    .stat-content p {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        padding: 1.5rem;
    }

    .btn-link {
        color: #3b82f6;
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.3s ease;
    }

    .btn-link:hover {
        color: #2563eb;
    }

    .announcement-item, .document-item {
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .announcement-item:last-child, .document-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .item-content {
        flex: 1;
    }

    .item-title {
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.25rem 0;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .item-meta {
        font-size: 0.75rem;
        color: #6b7280;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .item-badge {
        padding: 0.125rem 0.5rem;
        border-radius: 50px;
        font-size: 0.625rem;
        font-weight: 500;
        flex-shrink: 0;
    }

    .badge-new {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-urgent {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-general {
        background: #e5e7eb;
        color: #6b7280;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .quick-actions {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .quick-actions-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .quick-actions-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0;
    }

    .action-item {
        padding: 1.5rem;
        border-right: 1px solid #f3f4f6;
        border-bottom: 1px solid #f3f4f6;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .action-item:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }

    .action-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin: 0 auto 1rem auto;
    }

    .action-icon.documents { background: #dbeafe; color: #1d4ed8; }
    .action-icon.announcements { background: #d1fae5; color: #059669; }
    .action-icon.staff { background: #e9d5ff; color: #7c3aed; }
    .action-icon.feedback { background: #fed7aa; color: #ea580c; }

    .action-title {
        font-weight: 600;
        margin: 0 0 0.25rem 0;
        color: #111827;
    }

    .action-desc {
        font-size: 0.75rem;
        color: #6b7280;
        margin: 0;
    }

    .university-info {
        background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
        border-radius: 16px;
        padding: 2rem;
        color: white;
        text-align: center;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .university-info::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z'/%3E%3C/g%3E%3C/svg%3E");
    }

    .university-info-content {
        position: relative;
        z-index: 1;
    }

    .university-info h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .university-info p {
        margin: 0;
        opacity: 0.9;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }
        
        .content-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .welcome-text h1 {
            font-size: 2rem;
        }

        .user-info {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="home-container">
    <div class="home-wrapper">
        
        <!-- Welcome Header -->
        <div class="welcome-header">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>Welcome back, {{ $user->name }}!</h1>
                    <p>{{ ucfirst($user->department) }} Department • {{ ucfirst($user->level) }} Level</p>
                </div>
                <div class="user-info">
                    <div class="user-avatar">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="user-details">
                        <h3>{{ $user->matric_number }}</h3>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- University Information -->
        <div class="university-info">
            <div class="university-info-content">
                <h2>Nasarawa State University Keffi</h2>
                <p>Document Management System - Your gateway to academic resources, announcements, and communication</p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $recentDocuments->count() + 15 }}</h3>
                    <p>Available Documents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $recentAnnouncements->count() + 8 }}</h3>
                    <p>Active Announcements</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-content">
                    <h3>25</h3>
                    <p>Faculty Members</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ Auth::user()->feedbacks()->count() ?? 0 }}</h3>
                    <p>Your Feedbacks</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="quick-actions-header">
                <h2>
                    <i class="fas fa-rocket"></i>
                    Quick Actions
                </h2>
            </div>
            <div class="actions-grid">
                <a href="{{ route('student.documents') }}" class="action-item">
                    <div class="action-icon documents">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="action-title">Browse Documents</h3>
                    <p class="action-desc">Access lecture notes, assignments, and resources</p>
                </a>
                <a href="{{ route('student.announcements') }}" class="action-item">
                    <div class="action-icon announcements">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3 class="action-title">View Announcements</h3>
                    <p class="action-desc">Stay updated with latest news and notices</p>
                </a>
                <a href="{{ route('student.staff-directory') }}" class="action-item">
                    <div class="action-icon staff">
                        <i class="fas fa-address-book"></i>
                    </div>
                    <h3 class="action-title">Staff Directory</h3>
                    <p class="action-desc">Find lecturers and their contact information</p>
                </a>
                <a href="{{ route('student.feedbacks') }}" class="action-item">
                    <div class="action-icon feedback">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <h3 class="action-title">Submit Feedback</h3>
                    <p class="action-desc">Share your thoughts and get support</p>
                </a>
            </div>
        </div>

        <!-- Recent Content -->
        <div class="content-grid">
            <!-- Recent Announcements -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-bullhorn text-green-600"></i>
                        Recent Announcements
                    </h2>
                    <a href="{{ route('student.announcements') }}" class="btn-link">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-content">
                    @forelse($recentAnnouncements as $announcement)
                        <div class="announcement-item">
                            <div class="item-content">
                                <h3 class="item-title">{{ Str::limit($announcement->title, 50) }}</h3>
                                <div class="item-meta">
                                    <span><i class="fas fa-calendar"></i> {{ $announcement->created_at->format('M d') }}</span>
                                    <span><i class="fas fa-user"></i> {{ $announcement->user->name }}</span>
                                </div>
                            </div>
                            @if($announcement->created_at->isToday())
                                <span class="item-badge badge-new">New</span>
                            @elseif($announcement->category === 'exam')
                                <span class="item-badge badge-urgent">Urgent</span>
                            @else
                                <span class="item-badge badge-general">{{ ucfirst($announcement->category) }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-bullhorn"></i>
                            <p>No recent announcements</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Documents -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-file-alt text-blue-600"></i>
                        Recent Documents
                    </h2>
                    <a href="{{ route('student.documents') }}" class="btn-link">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="card-content">
                    @forelse($recentDocuments as $document)
                        <div class="document-item">
                            <div class="item-content">
                                <h3 class="item-title">{{ Str::limit($document->title, 50) }}</h3>
                                <div class="item-meta">
                                    <span><i class="fas fa-calendar"></i> {{ $document->created_at->format('M d') }}</span>
                                    <span><i class="fas fa-download"></i> {{ $document->downloads }} downloads</span>
                                </div>
                            </div>
                            @if($document->created_at->isToday())
                                <span class="item-badge badge-new">New</span>
                            @else
                                <span class="item-badge badge-general">{{ ucfirst($document->category) }}</span>
                            @endif
                        </div>
                    @empty
                        <div class="empty-state">
                            <i class="fas fa-file-alt"></i>
                            <p>No recent documents</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Important Information -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-info-circle text-blue-600"></i>
                    Important Information
                </h2>
            </div>
            <div class="card-content">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <div style="background: #f0f9ff; padding: 1rem; border-radius: 8px; border-left: 4px solid #3b82f6;">
                        <h4 style="margin: 0 0 0.5rem 0; color: #1e40af; font-size: 1rem;">
                            <i class="fas fa-graduation-cap"></i> Academic Session
                        </h4>
                        <p style="margin: 0; font-size: 0.875rem; color: #1e40af;">
                            2024/2025 Academic Session is currently ongoing. Check announcements for important dates.
                        </p>
                    </div>
                    <div style="background: #f0fdf4; padding: 1rem; border-radius: 8px; border-left: 4px solid #10b981;">
                        <h4 style="margin: 0 0 0.5rem 0; color: #065f46; font-size: 1rem;">
                            <i class="fas fa-clock"></i> Library Hours
                        </h4>
                        <p style="margin: 0; font-size: 0.875rem; color: #065f46;">
                            Extended hours during exam period: 7:00 AM - 11:00 PM daily.
                        </p>
                    </div>
                    <div style="background: #fef3c7; padding: 1rem; border-radius: 8px; border-left: 4px solid #f59e0b;">
                        <h4 style="margin: 0 0 0.5rem 0; color: #92400e; font-size: 1rem;">
                            <i class="fas fa-exclamation-triangle"></i> Support
                        </h4>
                        <p style="margin: 0; font-size: 0.875rem; color: #92400e;">
                            Need help? Use the feedback system to contact administrators.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection