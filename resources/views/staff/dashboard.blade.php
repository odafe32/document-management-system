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

    .dashboard-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

 

    .welcome-header {
        background: linear-gradient(135deg, darkgreen 0%, #2d5016 100%);
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

    .welcome-text h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: #fff;
    }

    .welcome-text p {
        font-size: 1.125rem;
        opacity: 0.9;
        margin: 0;
    }

    .welcome-stats {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .welcome-stat {
        text-align: center;
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .welcome-stat h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #fff;
    }

    .welcome-stat p {
        font-size: 0.875rem;
        margin: 0.25rem 0 0 0;
        opacity: 0.8;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-color);
    }

    .stat-card.documents::before { --accent-color: #3b82f6; }
    .stat-card.announcements::before { --accent-color: #10b981; }
    .stat-card.feedbacks::before { --accent-color: #f59e0b; }
    .stat-card.users::before { --accent-color: #8b5cf6; }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-icon.yellow { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.purple { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .stat-label {
        font-size: 1rem;
        color: #6b7280;
        margin: 0.25rem 0 0 0;
    }

    .stat-change {
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.5rem;
    }

    .stat-change.positive {
        color: #059669;
    }

    .stat-change.negative {
        color: #dc2626;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .main-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem 2rem;
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
        color: #111827;
    }

    .card-content {
        padding: 2rem;
    }

    .recent-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }

    .recent-item:last-child {
        border-bottom: none;
    }

    .recent-item:hover {
        background: #f8fafc;
        margin: 0 -2rem;
        padding: 1rem 2rem;
        border-radius: 8px;
    }

    .recent-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: white;
        flex-shrink: 0;
    }

    .recent-content {
        flex: 1;
        min-width: 0;
    }

    .recent-title {
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.25rem 0;
        font-size: 0.875rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .recent-meta {
        font-size: 0.75rem;
        color: #6b7280;
        margin: 0;
    }

    .recent-time {
        font-size: 0.75rem;
        color: #9ca3af;
        flex-shrink: 0;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        color: #374151;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        border-color: #3b82f6;
        background: #f8fafc;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        color: white;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #f3f4f6;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        color: #6b7280;
        flex-shrink: 0;
    }

    .activity-content {
        flex: 1;
        min-width: 0;
    }

    .activity-text {
        font-size: 0.875rem;
        color: #374151;
        margin: 0 0 0.25rem 0;
    }

    .activity-time {
        font-size: 0.75rem;
        color: #9ca3af;
        margin: 0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0 0 0.5rem 0;
        color: #374151;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
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

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .welcome-content {
            flex-direction: column;
            text-align: center;
        }
        
        .welcome-stats {
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .welcome-text h1 {
            font-size: 2rem;
        }
        
        .welcome-stats {
            flex-direction: column;
            gap: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-wrapper">
        
        <!-- Welcome Header -->
        <div class="welcome-header">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                    <p>Here's what's happening in your department today</p>
                </div>
                <div class="welcome-stats">
                    <div class="welcome-stat">
                        <h3>{{ $stats['documents']['total'] ?? 0 }}</h3>
                        <p>Documents</p>
                    </div>
                    <div class="welcome-stat">
                        <h3>{{ $stats['announcements']['total'] ?? 0 }}</h3>
                        <p>Announcements</p>
                    </div>
                    <div class="welcome-stat">
                        <h3>{{ $stats['feedbacks']['pending'] ?? 0 }}</h3>
                        <p>Pending Feedbacks</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <!-- Documents Stats -->
            <div class="stat-card documents">
                <div class="stat-header">
                    <div>
                        <h2 class="stat-number">{{ $stats['documents']['total'] ?? 0 }}</h2>
                        <p class="stat-label">Total Documents</p>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +{{ $stats['documents']['this_month'] ?? 0 }} this month
                        </div>
                    </div>
                    <div class="stat-icon blue">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stats['documents']['total'] > 0 ? min(($stats['documents']['public'] / $stats['documents']['total']) * 100, 100) : 0 }}%"></div>
                </div>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.5rem 0 0 0;">
                    {{ $stats['documents']['public'] ?? 0 }} public, {{ $stats['documents']['private'] ?? 0 }} private
                </p>
            </div>

            <!-- Announcements Stats -->
            <div class="stat-card announcements">
                <div class="stat-header">
                    <div>
                        <h2 class="stat-number">{{ $stats['announcements']['total'] ?? 0 }}</h2>
                        <p class="stat-label">Announcements</p>
                        <div class="stat-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +{{ $stats['announcements']['this_week'] ?? 0 }} this week
                        </div>
                    </div>
                    <div class="stat-icon green">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stats['announcements']['total'] > 0 ? min(($stats['announcements']['active'] / $stats['announcements']['total']) * 100, 100) : 0 }}%; background: linear-gradient(90deg, #10b981, #059669);"></div>
                </div>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.5rem 0 0 0;">
                    {{ $stats['announcements']['active'] ?? 0 }} active, {{ $stats['announcements']['expired'] ?? 0 }} expired
                </p>
            </div>

            <!-- Feedbacks Stats -->
            <div class="stat-card feedbacks">
                <div class="stat-header">
                    <div>
                        <h2 class="stat-number">{{ $stats['feedbacks']['total'] ?? 0 }}</h2>
                        <p class="stat-label">Student Feedbacks</p>
                        <div class="stat-change {{ ($stats['feedbacks']['pending'] ?? 0) > 0 ? 'negative' : 'positive' }}">
                            <i class="fas fa-{{ ($stats['feedbacks']['pending'] ?? 0) > 0 ? 'exclamation-triangle' : 'check' }}"></i>
                            {{ $stats['feedbacks']['pending'] ?? 0 }} pending
                        </div>
                    </div>
                    <div class="stat-icon yellow">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stats['feedbacks']['total'] > 0 ? min(($stats['feedbacks']['resolved'] / $stats['feedbacks']['total']) * 100, 100) : 0 }}%; background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
                </div>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.5rem 0 0 0;">
                    {{ $stats['feedbacks']['resolved'] ?? 0 }} resolved, {{ $stats['feedbacks']['in_review'] ?? 0 }} in review
                </p>
            </div>

            <!-- System Stats -->
            <div class="stat-card users">
                <div class="stat-header">
                    <div>
                        <h2 class="stat-number">{{ $stats['system']['storage_used'] ?? '0 MB' }}</h2>
                        <p class="stat-label">Storage Used</p>
                        <div class="stat-change positive">
                            <i class="fas fa-database"></i>
                            {{ $stats['system']['files_count'] ?? 0 }} files
                        </div>
                    </div>
                    <div class="stat-icon purple">
                        <i class="fas fa-server"></i>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $stats['system']['storage_percentage'] ?? 15 }}%; background: linear-gradient(90deg, #8b5cf6, #7c3aed);"></div>
                </div>
                <p style="font-size: 0.75rem; color: #6b7280; margin: 0.5rem 0 0 0;">
                    {{ $stats['system']['storage_percentage'] ?? 15 }}% of total capacity
                </p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Main Content -->
            <div class="main-content">
                
                <!-- Recent Documents -->
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-file-alt"></i>
                            Recent Documents
                        </h2>
                        <a href="{{ route('staff.documents') }}" class="btn-primary">
                            <i class="fas fa-eye"></i>View All
                        </a>
                    </div>
                    <div class="card-content">
                        @forelse($recentDocuments ?? [] as $document)
                            <div class="recent-item">
                                <div class="recent-icon blue">
                                    <i class="fas fa-file"></i>
                                </div>
                                <div class="recent-content">
                                    <h4 class="recent-title">{{ $document->title }}</h4>
                                    <p class="recent-meta">{{ $document->category }} • {{ $document->downloads }} downloads</p>
                                </div>
                                <div class="recent-time">{{ $document->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-file-alt"></i>
                                <h3>No documents yet</h3>
                                <p>Upload your first document to get started</p>
                                <a href="{{ route('staff.documents') }}" class="btn-primary" style="margin-top: 1rem;">
                                    <i class="fas fa-plus"></i>Upload Document
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Announcements -->
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-bullhorn"></i>
                            Recent Announcements
                        </h2>
                        <a href="{{ route('staff.announcements') }}" class="btn-primary">
                            <i class="fas fa-eye"></i>View All
                        </a>
                    </div>
                    <div class="card-content">
                        @forelse($recentAnnouncements ?? [] as $announcement)
                            <div class="recent-item">
                                <div class="recent-icon green">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div class="recent-content">
                                    <h4 class="recent-title">{{ $announcement->title }}</h4>
                                    <p class="recent-meta">{{ ucfirst($announcement->category) }} • {{ ucfirst($announcement->visibility) }}</p>
                                </div>
                                <div class="recent-time">{{ $announcement->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-bullhorn"></i>
                                <h3>No announcements yet</h3>
                                <p>Create your first announcement to inform students</p>
                                <a href="{{ route('staff.announcements.create') }}" class="btn-primary" style="margin-top: 1rem;">
                                    <i class="fas fa-plus"></i>Create Announcement
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Feedbacks -->
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-comments"></i>
                            Recent Feedbacks
                        </h2>
                        <a href="{{ route('staff.feedbacks') }}" class="btn-primary">
                            <i class="fas fa-eye"></i>View All
                        </a>
                    </div>
                    <div class="card-content">
                        @forelse($recentFeedbacks ?? [] as $feedback)
                            <div class="recent-item">
                                <div class="recent-icon yellow">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="recent-content">
                                    <h4 class="recent-title">{{ $feedback->subject }}</h4>
                                    <p class="recent-meta">{{ $feedback->user->name }} • {{ ucfirst($feedback->status) }}</p>
                                </div>
                                <div class="recent-time">{{ $feedback->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-comments"></i>
                                <h3>No feedbacks yet</h3>
                                <p>Student feedbacks will appear here</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="card-content">
                        <div class="quick-actions">
                            <a href="{{ route('staff.documents') }}" class="action-btn">
                                <div class="action-icon blue">
                                    <i class="fas fa-upload"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.875rem;">Upload Document</h4>
                                    <p style="margin: 0; font-size: 0.75rem; color: #6b7280;">Share files with students</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('staff.announcements.create') }}" class="action-btn">
                                <div class="action-icon green">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.875rem;">New Announcement</h4>
                                    <p style="margin: 0; font-size: 0.75rem; color: #6b7280;">Notify students</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('staff.feedbacks') }}" class="action-btn">
                                <div class="action-icon yellow">
                                    <i class="fas fa-reply"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.875rem;">Reply to Feedbacks</h4>
                                    <p style="margin: 0; font-size: 0.75rem; color: #6b7280;">{{ $stats['feedbacks']['pending'] ?? 0 }} pending</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('staff.profile') }}" class="action-btn">
                                <div class="action-icon purple">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h4 style="margin: 0; font-size: 0.875rem;">Update Profile</h4>
                                    <p style="margin: 0; font-size: 0.75rem; color: #6b7280;">Manage your account</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- System Status -->
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-chart-line"></i>
                            System Status
                        </h2>
                    </div>
                    <div class="card-content">
                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #374151;">Server Status</span>
                                <span style="font-size: 0.75rem; color: #059669; font-weight: 500;">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i> Online
                                </span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 98%; background: linear-gradient(90deg, #10b981, #059669);"></div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #374151;">Database</span>
                                <span style="font-size: 0.75rem; color: #059669; font-weight: 500;">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i> Healthy
                                </span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 95%; background: linear-gradient(90deg, #10b981, #059669);"></div>
                            </div>
                        </div>
                        
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; color: #374151;">Storage</span>
                                <span style="font-size: 0.75rem; color: #f59e0b; font-weight: 500;">
                                    {{ $stats['system']['storage_percentage'] ?? 15 }}%
                                </span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $stats['system']['storage_percentage'] ?? 15 }}%; background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-history"></i>
                            Recent Activity
                        </h2>
                    </div>
                    <div class="card-content">
                        @forelse($recentActivity ?? [] as $activity)
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    {{ substr($activity['user'] ?? 'U', 0, 1) }}
                                </div>
                                <div class="activity-content">
                                    <p class="activity-text">{{ $activity['text'] ?? 'Activity occurred' }}</p>
                                    <p class="activity-time">{{ $activity['time'] ?? 'Just now' }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-history"></i>
                                <h3>No recent activity</h3>
                                <p>Activity will appear here</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-refresh dashboard data every 5 minutes
    setInterval(function() {
        // You can add AJAX calls here to refresh specific sections
        console.log('Dashboard auto-refresh');
    }, 300000);

    // Add some interactivity to stat cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            const cardType = this.classList[1]; // documents, announcements, etc.
            
            switch(cardType) {
                case 'documents':
                    window.location.href = '{{ route("staff.documents") }}';
                    break;
                case 'announcements':
                    window.location.href = '{{ route("staff.announcements") }}';
                    break;
                case 'feedbacks':
                    window.location.href = '{{ route("staff.feedbacks") }}';
                    break;
                default:
                    break;
            }
        });
    });
</script>
@endsection