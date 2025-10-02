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

    .documents-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .documents-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .page-header {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
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

    .department-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
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
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
        overflow: hidden;
        background: white;
    }

    .document-item:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .document-header {
        padding: 1.5rem;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .document-info {
        flex: 1;
    }

    .document-title {
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.5rem 0;
        font-size: 1.125rem;
    }

    .document-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: #6b7280;
        flex-wrap: wrap;
        align-items: center;
    }

    .document-body {
        padding: 1.5rem;
    }

    .document-description {
        color: #374151;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .document-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .category-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .category-lecture {
        background: #dbeafe;
        color: #1e40af;
    }

    .category-timetable {
        background: #fef3c7;
        color: #92400e;
    }

    .category-memo {
        background: #e9d5ff;
        color: #7c3aed;
    }

    .category-other {
        background: #f3f4f6;
        color: #6b7280;
    }

    .department-badge-small {
        background: #d1fae5;
        color: #065f46;
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
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

    .btn-success {
        background: #10b981;
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

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
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

        .document-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .document-meta {
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

<div class="documents-container">
    <div class="documents-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-folder-open" style="font-size: 2rem;"></i>
                    <div>
                        <h1>Department Documents</h1>
                        <div class="department-badge">
                            <i class="fas fa-building"></i>
                            {{ ucfirst($userDepartment) }} Department
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-folder"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total'] }}</h3>
                    <p>Total Documents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['department'] }}</h3>
                    <p>Department Specific</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['general'] }}</h3>
                    <p>General Documents</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-download"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ number_format($stats['downloads']) }}</h3>
                    <p>Total Downloads</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <h2>
                    <i class="fas fa-list"></i>
                    Available Documents
                </h2>

                <!-- Filters -->
                <form method="GET" class="filters">
                    <select name="category" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                        <option value="lecture" {{ ($currentCategory ?? '') == 'lecture' ? 'selected' : '' }}>Lecture Notes</option>
                        <option value="timetable" {{ ($currentCategory ?? '') == 'timetable' ? 'selected' : '' }}>Timetables</option>
                        <option value="memo" {{ ($currentCategory ?? '') == 'memo' ? 'selected' : '' }}>Memos</option>
                        <option value="other" {{ ($currentCategory ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>

                    <input type="text" name="search" class="search-box" placeholder="Search documents..."
                           value="{{ $currentSearch ?? '' }}" onchange="this.form.submit()">
                </form>
            </div>

            <div class="documents-list">
                @forelse($documents as $document)
                    <div class="document-item">
                        <div class="document-header">
                            <div class="file-icon" style="background: {{ $document->file_color }}20; color: {{ $document->file_color }};">
                                <i class="{{ $document->file_icon }}"></i>
                            </div>

                            <div class="document-info">
                                <h3 class="document-title">{{ $document->title }}</h3>
                                <div class="document-meta">
                                    <span><i class="fas fa-user"></i> {{ $document->user->name ?? 'Admin' }}</span>
                                    <span class="category-badge category-{{ $document->category }}">
                                        <i class="fas fa-tag"></i>
                                        {{ $document->category_display }}
                                    </span>
                                    @if($document->is_department_specific)
                                        <span class="department-badge-small">
                                            <i class="fas fa-building"></i>
                                            {{ $document->target_department_display }}
                                        </span>
                                    @else
                                        <span class="department-badge-small" style="background: #fef3c7; color: #92400e;">
                                            <i class="fas fa-globe"></i>
                                            All Departments
                                        </span>
                                    @endif
                                    <span><i class="fas fa-calendar"></i> {{ $document->created_at->format('M d, Y') }}</span>
                                    <span><i class="fas fa-file"></i> {{ $document->file_size }}</span>
                                    <span><i class="fas fa-download"></i> {{ number_format($document->downloads) }} downloads</span>
                                </div>
                            </div>
                        </div>

                        <div class="document-body">
                            @if($document->description)
                                <div class="document-description">
                                    {{ $document->description }}
                                </div>
                            @endif

                            <div class="document-actions">
                                <a href="{{ route('student.documents.download', $document) }}" class="btn-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h3>No documents found</h3>
                        <p>There are no documents available for your department at the moment.</p>
                    </div>
                @endforelse


            </div>
        </div>
    </div>
</div>
@endsection
