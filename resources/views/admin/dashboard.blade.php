@extends('layout.admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        background-color: #f8fafc;
        color: #2d3748;
        line-height: 1.6;
    }

    .dashboard-container {
        min-height: 100vh;
        padding: 2rem 0;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .page-header {
        background: #004400;
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

    .welcome-section h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: #fff;
    }

    .welcome-section p {
        font-size: 1.125rem;
        margin: 0;
        color: rgba(255,255,255,0.9);
    }

    .header-stats {
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .header-stat {
        text-align: center;
    }

    .header-stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #fff;
        display: block;
    }

    .header-stat-label {
        font-size: 0.875rem;
        color: rgba(255,255,255,0.8);
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
        box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1);
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
    .stat-card.users::before { --accent-color: #10b981; }
    .stat-card.announcements::before { --accent-color: #f59e0b; }
    .stat-card.feedbacks::before { --accent-color: #ef4444; }

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
    .stat-icon.red { background: linear-gradient(135deg, #ef4444, #dc2626); }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }

    .stat-change {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
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
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        color: #374151;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .action-btn:hover {
        border-color: #3b82f6;
        background: #f8fafc;
        transform: translateY(-1px);
        color: #3b82f6;
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: white;
    }

    .action-icon.blue { background: #3b82f6; }
    .action-icon.green { background: #10b981; }
    .action-icon.yellow { background: #f59e0b; }
    .action-icon.red { background: #ef4444; }

    .recent-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .recent-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8fafc;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .recent-item:hover {
        background: #e5e7eb;
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
    }

    .recent-title {
        font-weight: 500;
        color: #111827;
        margin: 0 0 0.25rem 0;
    }

    .recent-meta {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .btn-primary {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .header-stats {
            justify-content: center;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="welcome-section">
                    <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                    <p>Here's what's happening in your system today</p>
                </div>
                <div class="header-stats">
                    @php
                        $totalUsers = \App\Models\User::count();
                        $totalDocuments = \App\Models\Document::count();
                        $totalAnnouncements = \App\Models\Announcement::count();
                    @endphp
                    <div class="header-stat">
                        <span class="header-stat-number">{{ $totalUsers }}</span>
                        <span class="header-stat-label">Total Users</span>
                    </div>
                    <div class="header-stat">
                        <span class="header-stat-number">{{ $totalDocuments }}</span>
                        <span class="header-stat-label">Documents</span>
                    </div>
                    <div class="header-stat">
                        <span class="header-stat-number">{{ $totalAnnouncements }}</span>
                        <span class="header-stat-label">Announcements</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            @php
                $documentStats = [
                    'total' => \App\Models\Document::count(),
                    'thisMonth' => \App\Models\Document::whereMonth('created_at', now()->month)->count(),
                    'downloads' => \App\Models\Document::sum('downloads')
                ];
                
                $userStats = [
                    'total' => \App\Models\User::count(),
                    'students' => \App\Models\User::where('role', 'student')->count(),
                    'staff' => \App\Models\User::whereIn('role', ['admin', 'staff'])->count(),
                    'active' => \App\Models\User::where('status', 'active')->count()
                ];
                
                $announcementStats = [
                    'total' => \App\Models\Announcement::count(),
                    'active' => \App\Models\Announcement::where('is_active', true)->count(),
                    'views' => \App\Models\Announcement::sum('views')
                ];
                
                $feedbackStats = [
                    'total' => \App\Models\Feedback::count(),
                    'pending' => \App\Models\Feedback::where('status', 'pending')->count(),
                    'resolved' => \App\Models\Feedback::where('status', 'resolved')->count()
                ];
            @endphp

            <div class="stat-card documents">
                <div class="stat-header">
                    <div class="stat-icon blue">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($documentStats['total']) }}</div>
                <div class="stat-label">Total Documents</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    {{ $documentStats['thisMonth'] }} this month
                </div>
            </div>

            <div class="stat-card users">
                <div class="stat-header">
                    <div class="stat-icon green">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($userStats['total']) }}</div>
                <div class="stat-label">Total Users</div>
                <div class="stat-change positive">
                    <i class="fas fa-check-circle"></i>
                    {{ $userStats['active'] }} active users
                </div>
            </div>

            <div class="stat-card announcements">
                <div class="stat-header">
                    <div class="stat-icon yellow">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($announcementStats['total']) }}</div>
                <div class="stat-label">Announcements</div>
                <div class="stat-change positive">
                    <i class="fas fa-eye"></i>
                    {{ number_format($announcementStats['views']) }} total views
                </div>
            </div>

            <div class="stat-card feedbacks">
                <div class="stat-header">
                    <div class="stat-icon red">
                        <i class="fas fa-comments"></i>
                    </div>
                </div>
                <div class="stat-number">{{ number_format($feedbackStats['total']) }}</div>
                <div class="stat-label">Feedbacks</div>
                <div class="stat-change {{ $feedbackStats['pending'] > 0 ? 'negative' : 'positive' }}">
                    <i class="fas fa-{{ $feedbackStats['pending'] > 0 ? 'exclamation-triangle' : 'check-circle' }}"></i>
                    {{ $feedbackStats['pending'] }} pending
                </div>
            </div>
        </div>

        <div class="content-grid">
            <!-- Main Content -->
            <div class="main-content">
                
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('admin.documents') }}" class="action-btn">
                                <div class="action-icon blue">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div>
                                    <div>Manage Documents</div>
                                    <small>Upload & organize files</small>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.users') }}" class="action-btn">
                                <div class="action-icon green">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <div>Manage Users</div>
                                    <small>Add & edit user accounts</small>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.announcements') }}" class="action-btn">
                                <div class="action-icon yellow">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <div>
                                    <div>Announcements</div>
                                    <small>Create & manage posts</small>
                                </div>
                            </a>
                            
                            <a href="{{ route('admin.feedbacks') }}" class="action-btn">
                                <div class="action-icon red">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <div>
                                    <div>View Feedbacks</div>
                                    <small>Respond to user feedback</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Documents -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-clock"></i>
                            Recent Documents
                        </h2>
                        <a href="{{ route('admin.documents') }}" class="btn-primary">
                            <i class="fas fa-eye"></i>
                            View All
                        </a>
                    </div>
                    <div class="card-body">
                        @php
                            $recentDocuments = \App\Models\Document::with('user')->latest()->take(5)->get();
                        @endphp
                        
                        @if($recentDocuments->count() > 0)
                            <div class="recent-list">
                                @foreach($recentDocuments as $document)
                                    <div class="recent-item">
                                        <div class="recent-icon blue">
                                            <i class="fas fa-file-alt"></i>
                                        </div>
                                        <div class="recent-content">
                                            <h4 class="recent-title">{{ Str::limit($document->title, 50) }}</h4>
                                            <p class="recent-meta">
                                                By {{ $document->user->name ?? 'Unknown' }} • {{ $document->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-file-alt"></i>
                                <p>No documents uploaded yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                
                <!-- System Status -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-server"></i>
                            System Status
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Server Status</span>
                                <span style="color: #10b981; font-weight: 500;">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i> Online
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Database</span>
                                <span style="color: #10b981; font-weight: 500;">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i> Connected
                                </span>
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span>Storage</span>
                                <span style="color: #f59e0b; font-weight: 500;">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i> 75% Used
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-activity"></i>
                            Recent Activity
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $recentActivities = collect();
                            
                            // Get recent documents
                            $recentDocs = \App\Models\Document::with('user')->latest()->take(3)->get();
                            foreach($recentDocs as $doc) {
                                $recentActivities->push([
                                    'type' => 'document',
                                    'title' => 'Document uploaded',
                                    'description' => $doc->title,
                                    'user' => $doc->user->name ?? 'Unknown',
                                    'time' => $doc->created_at,
                                    'icon' => 'file-alt',
                                    'color' => 'blue'
                                ]);
                            }
                            
                            // Get recent users
                            $recentUsers = \App\Models\User::latest()->take(2)->get();
                            foreach($recentUsers as $user) {
                                $recentActivities->push([
                                    'type' => 'user',
                                    'title' => 'New user registered',
                                    'description' => $user->name,
                                    'user' => 'System',
                                    'time' => $user->created_at,
                                    'icon' => 'user-plus',
                                    'color' => 'green'
                                ]);
                            }
                            
                            $recentActivities = $recentActivities->sortByDesc('time')->take(5);
                        @endphp
                        
                        @if($recentActivities->count() > 0)
                            <div class="recent-list">
                                @foreach($recentActivities as $activity)
                                    <div class="recent-item">
                                        <div class="recent-icon {{ $activity['color'] }}">
                                            <i class="fas fa-{{ $activity['icon'] }}"></i>
                                        </div>
                                        <div class="recent-content">
                                            <h4 class="recent-title">{{ $activity['title'] }}</h4>
                                            <p class="recent-meta">
                                                {{ Str::limit($activity['description'], 30) }} • {{ $activity['time']->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-activity"></i>
                                <p>No recent activity</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            Quick Stats
                        </h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; flex-direction: column; gap: 1rem; font-size: 0.875rem;">
                            <div style="display: flex; justify-content: space-between;">
                                <span>Students:</span>
                                <strong>{{ $userStats['students'] }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Staff:</span>
                                <strong>{{ $userStats['staff'] }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Active Announcements:</span>
                                <strong>{{ $announcementStats['active'] }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Total Downloads:</span>
                                <strong>{{ number_format($documentStats['downloads']) }}</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span>Pending Feedbacks:</span>
                                <strong style="color: {{ $feedbackStats['pending'] > 0 ? '#ef4444' : '#10b981' }};">
                                    {{ $feedbackStats['pending'] }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection