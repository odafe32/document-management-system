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

    .users-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .users-wrapper {
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

    .btn-warning {
        background: #f59e0b;
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

    .btn-warning:hover {
        background: #d97706;
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
    .stat-icon.red { background: #fee2e2; color: #dc2626; }
    .stat-icon.gray { background: #f3f4f6; color: #6b7280; }

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

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table th,
    .users-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }

    .users-table th {
        background: #f9fafb;
        font-weight: 600;
        color: #374151;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        background: darkgreen;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1rem;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-details h4 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        color: #111827;
    }

    .user-details p {
        margin: 0;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .role-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .role-admin {
        background: #fee2e2;
        color: #7f1d1d;
    }

    .role-staff {
        background: #dbeafe;
        color: #1e40af;
    }

    .role-student {
        background: #d1fae5;
        color: #065f46;
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

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
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
        padding: 1.5rem;
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
        
        .users-table {
            font-size: 0.875rem;
        }
        
        .users-table th,
        .users-table td {
            padding: 0.75rem 0.5rem;
        }
        
        .actions {
            flex-direction: column;
            gap: 0.25rem;
        }
    }
</style>

<div class="users-container">
    <div class="users-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-users" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff">User Management</h1>
                </div>
                <a href="{{ route('admin.users.create') }}" class="btn-primary">
                    <i class="fas fa-plus"></i>Create User
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
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <p>Total Users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['students'] ?? 0 }}</h3>
                    <p>Students</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['staff'] ?? 0 }}</h3>
                    <p>Staff Members</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['admins'] ?? 0 }}</h3>
                    <p>Administrators</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['active'] ?? 0 }}</h3>
                    <p>Active Users</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon gray">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $stats['inactive'] ?? 0 }}</h3>
                    <p>Inactive Users</p>
                </div>
            </div>
        </div>

        <div class="content-layout">
            <!-- Main Content -->
            <div class="main-content">
                <div class="content-header">
                    <h2>
                        <i class="fas fa-list"></i>
                        All Users
                    </h2>
                    
                    <!-- Filters -->
                    <form method="GET" class="filters">
                        <select name="role" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            <option value="admin" {{ ($currentRole ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ ($currentRole ?? '') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="student" {{ ($currentRole ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                        </select>
                        
                        <select name="status" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="active" {{ ($currentStatus ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ ($currentStatus ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        
                        <select name="department" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department }}" {{ ($currentDepartment ?? '') == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                            @endforeach
                        </select>
                        
                        <select name="faculty" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Faculties</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty }}" {{ ($currentFaculty ?? '') == $faculty ? 'selected' : '' }}>
                                    {{ $faculty }}
                                </option>
                            @endforeach
                        </select>
                        
                        <input type="text" name="search" class="search-box" placeholder="Search users..." 
                               value="{{ $currentSearch ?? '' }}" onchange="this.form.submit()">
                    </form>
                </div>

                <div style="overflow-x: auto;">
                    @if(isset($users) && $users->count() > 0)
                        <table class="users-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>ID/Matric</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <div class="user-info">
                                                <div class="user-avatar">
                                                    @if($user->avatar)
                                                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="avatar-img">
                                                    @else
                                                        <div class="avatar-placeholder">
                                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="user-details">
                                                    <h4>{{ $user->name }}</h4>
                                                    <p>{{ $user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="role-badge role-{{ $user->role }}">
                                                <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : ($user->role === 'staff' ? 'chalkboard-teacher' : 'user-graduate') }}"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->role === 'student')
                                                <span style="font-weight: 500;">{{ $user->matric_number ?? 'N/A' }}</span>
                                                @if($user->level)
                                                    <br><small style="color: #6b7280;">Level {{ $user->level }}</small>
                                                @endif
                                            @else
                                                <span style="font-weight: 500;">{{ $user->staff_id ?? 'N/A' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $user->department ?? 'N/A' }}</strong>
                                                @if($user->faculty)
                                                    <br><small style="color: #6b7280;">{{ $user->faculty }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $user->status }}">
                                                <i class="fas fa-{{ $user->status === 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->last_login_at)
                                                <span style="font-size: 0.875rem;">{{ $user->last_login_at->diffForHumans() }}</span>
                                            @else
                                                <span style="color: #6b7280; font-size: 0.875rem;">Never</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-info" title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                @if($user->id !== Auth::id())
                                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn-warning" title="{{ $user->status === 'active' ? 'Deactivate' : 'Activate' }} User">
                                                            <i class="fas fa-{{ $user->status === 'active' ? 'pause' : 'play' }}"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    <button onclick="confirmDelete('{{ $user->id }}', '{{ addslashes($user->name) }}')" class="btn-danger" title="Delete User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <span class="btn-secondary" title="Cannot modify your own account">
                                                        <i class="fas fa-lock"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h3>No users found</h3>
                            <p>Create your first user to get started.</p>
                            <a href="{{ route('admin.users.create') }}" class="btn-primary" style="background: darkgreen; margin-top: 1rem;">
                                <i class="fas fa-plus"></i>Create User
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Pagination -->
                @if(isset($users) && $users->hasPages())
                    <div class="pagination">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Quick Actions -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="sidebar-content">
                        <a href="{{ route('admin.users.create') }}" class="btn-primary" style="width: 100%; margin-bottom: 1rem; background: darkgreen; justify-content: center;">
                            <i class="fas fa-plus"></i>Create User
                        </a>
                        <a href="{{ route('admin.users') }}" class="btn-secondary" style="width: 100%; justify-content: center;">
                            <i class="fas fa-refresh"></i>Refresh List
                        </a>
                    </div>
                </div>

                <!-- User Roles Info -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-info-circle"></i> User Roles</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><strong>Admin:</strong> Full system access</p>
                            <p><strong>Staff:</strong> Can manage documents and announcements</p>
                            <p><strong>Student:</strong> Can view documents and submit feedback</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Privileges -->
                <div class="sidebar-card">
                    <div class="sidebar-header">
                        <h3><i class="fas fa-shield-alt"></i> Admin Privileges</h3>
                    </div>
                    <div class="sidebar-content">
                        <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">
                            <p><i class="fas fa-check text-green-600"></i> Create any user type</p>
                            <p><i class="fas fa-check text-green-600"></i> Edit all user accounts</p>
                            <p><i class="fas fa-check text-green-600"></i> Activate/deactivate users</p>
                            <p><i class="fas fa-check text-green-600"></i> Delete user accounts</p>
                            <p><i class="fas fa-times text-red-600"></i> Cannot modify own account status</p>
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
            <p>This action cannot be undone. The user account and all associated data will be permanently deleted.</p>
        </div>
        
        <p>Are you sure you want to delete the user:</p>
        <p style="font-weight: 600; color: #111827; margin: 1rem 0;"><span id="deleteUserName"></span></p>
        
        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
            <button onclick="closeModal('deleteModal')" class="btn-secondary">
                <i class="fas fa-times"></i>Cancel
            </button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">
                    <i class="fas fa-trash"></i>Delete User
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
    function confirmDelete(userId, userName) {
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteForm').action = `/admin/users/${userId}`;
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