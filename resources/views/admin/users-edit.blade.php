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

    .edit-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .edit-wrapper {
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

    .user-info-card {
        background: #f8fafc;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .current-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
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
        font-size: 1.5rem;
    }

    .user-details h3 {
        margin: 0 0 0.5rem 0;
        font-weight: 600;
        color: #111827;
        font-size: 1.25rem;
    }

    .user-details p {
        margin: 0;
        font-size: 0.875rem;
        color: #6b7280;
    }

    .user-meta {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }

    .meta-badge {
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

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #f3f4f6;
        color: #6b7280;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 1rem;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-control.error {
        border-color: #ef4444;
    }

    .form-control.error:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .text-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-grid-full {
        grid-column: 1 / -1;
    }

    .role-specific {
        display: none;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .role-specific.show {
        display: block;
    }

    .role-specific h3 {
        margin: 0 0 1rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        margin-top: 1rem;
    }

    .file-upload-area:hover {
        border-color: #4f46e5;
        background: #f8fafc;
    }

    .file-upload-area.dragover {
        border-color: #4f46e5;
        background: #f0f9ff;
    }

    .password-section {
        background: #fef3c7;
        border: 1px solid #f59e0b;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .password-section h4 {
        margin: 0 0 0.5rem 0;
        font-size: 0.875rem;
        font-weight: 600;
        color: #92400e;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .password-section p {
        margin: 0;
        font-size: 0.75rem;
        color: #92400e;
    }

    .form-actions {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn-success {
        background: #10b981;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    .btn-gray {
        background: #6b7280;
        color: white;
        border: none;
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

    .btn-gray:hover {
        background: #4b5563;
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

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid #ef4444;
        color: #7f1d1d;
    }

    .hidden {
        display: none !important;
    }

    .help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .required {
        color: #ef4444;
    }

    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .page-header-content {
            flex-direction: column;
            text-align: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .user-info-card {
            flex-direction: column;
            text-align: center;
        }
    }
</style>

<div class="edit-container">
    <div class="edit-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-user-edit" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff;">Edit User</h1>
                </div>
                <a href="{{ route('admin.users') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i>Back to Users
                </a>
            </div>
        </div>

        <!-- Error Messages -->
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

        <!-- Current User Info -->
        <div class="card">
            <div class="card-header">
                <h2>
                    <i class="fas fa-info-circle text-blue-600"></i>
                    Current User Information
                </h2>
            </div>
            <div class="card-content">
                <div class="user-info-card">
                    <div class="current-avatar">
                        @if($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="avatar-img">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="user-details">
                        <h3>{{ $user->name }}</h3>
                        <p>{{ $user->email }}</p>
                        <div class="user-meta">
                            <span class="meta-badge role-{{ $user->role }}">
                                <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : ($user->role === 'staff' ? 'chalkboard-teacher' : 'user-graduate') }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="meta-badge status-{{ $user->status }}">
                                <i class="fas fa-{{ $user->status === 'active' ? 'check-circle' : 'times-circle' }}"></i>
                                {{ ucfirst($user->status) }}
                            </span>
                            @if($user->role === 'student' && $user->matric_number)
                                <span class="meta-badge" style="background: #e0e7ff; color: #3730a3;">
                                    <i class="fas fa-id-card"></i>
                                    {{ $user->matric_number }}
                                </span>
                            @elseif(in_array($user->role, ['staff', 'admin']) && $user->staff_id)
                                <span class="meta-badge" style="background: #e0e7ff; color: #3730a3;">
                                    <i class="fas fa-id-badge"></i>
                                    {{ $user->staff_id }}
                                </span>
                            @endif
                        </div>
                        <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #6b7280;">
                            <p>Created: {{ $user->created_at->format('M d, Y \a\t g:i A') }}</p>
                            @if($user->last_login_at)
                                <p>Last Login: {{ $user->last_login_at->diffForHumans() }}</p>
                            @else
                                <p>Last Login: Never</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-edit text-blue-600"></i>
                        Edit Basic Information
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user text-gray-400"></i>
                                Full Name <span class="required">*</span>
                            </label>
                            <input type="text" name="name" class="form-control @error('name') error @enderror" 
                                   value="{{ old('name', $user->name) }}" required 
                                   placeholder="Enter full name">
                            @error('name')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope text-gray-400"></i>
                                Email Address <span class="required">*</span>
                            </label>
                            <input type="email" name="email" class="form-control @error('email') error @enderror" 
                                   value="{{ old('email', $user->email) }}" required 
                                   placeholder="Enter email address">
                            @error('email')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user-tag text-gray-400"></i>
                                User Role <span class="required">*</span>
                            </label>
                            <select name="role" id="roleSelect" class="form-control @error('role') error @enderror" required>
                                <option value="">Select Role</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff Member</option>
                                <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                            </select>
                            @error('role')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-toggle-on text-gray-400"></i>
                                Account Status <span class="required">*</span>
                            </label>
                            <select name="status" class="form-control @error('status') error @enderror" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Role-specific fields -->
                    <div id="studentFields" class="role-specific {{ old('role', $user->role) == 'student' ? 'show' : '' }}">
                        <h3><i class="fas fa-user-graduate"></i> Student Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                    Matriculation Number <span class="required">*</span>
                                </label>
                                <input type="text" name="matric_number" class="form-control @error('matric_number') error @enderror" 
                                       value="{{ old('matric_number', $user->matric_number) }}" 
                                       placeholder="Enter matriculation number">
                                @error('matric_number')
                                    <p class="text-error">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-layer-group text-gray-400"></i>
                                    Level <span class="required">*</span>
                                </label>
                                <select name="level" class="form-control @error('level') error @enderror">
                                    <option value="">Select Level</option>
                                    <option value="100" {{ old('level', $user->level) == '100' ? 'selected' : '' }}>100 Level</option>
                                    <option value="200" {{ old('level', $user->level) == '200' ? 'selected' : '' }}>200 Level</option>
                                    <option value="300" {{ old('level', $user->level) == '300' ? 'selected' : '' }}>300 Level</option>
                                    <option value="400" {{ old('level', $user->level) == '400' ? 'selected' : '' }}>400 Level</option>
                                    <option value="500" {{ old('level', $user->level) == '500' ? 'selected' : '' }}>500 Level</option>
                                    <option value="600" {{ old('level', $user->level) == '600' ? 'selected' : '' }}>600 Level</option>
                                </select>
                                @error('level')
                                    <p class="text-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div id="staffFields" class="role-specific {{ old('role', $user->role) == 'staff' ? 'show' : '' }}">
                        <h3><i class="fas fa-chalkboard-teacher"></i> Staff Information</h3>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-id-badge text-gray-400"></i>
                                Staff ID <span class="required">*</span>
                            </label>
                            <input type="text" name="staff_id" class="form-control @error('staff_id') error @enderror" 
                                   value="{{ old('staff_id', $user->staff_id) }}" 
                                   placeholder="Enter staff ID">
                            @error('staff_id')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div id="adminFields" class="role-specific {{ old('role', $user->role) == 'admin' ? 'show' : '' }}">
                        <h3><i class="fas fa-user-shield"></i> Administrator Information</h3>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-id-badge text-gray-400"></i>
                                Staff ID <span class="required">*</span>
                            </label>
                            <input type="text" name="staff_id" class="form-control @error('staff_id') error @enderror" 
                                   value="{{ old('staff_id', $user->staff_id) }}" 
                                   placeholder="Enter staff ID">
                            @error('staff_id')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Update -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-key text-blue-600"></i>
                        Password Update
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="password-section">
                        <h4><i class="fas fa-info-circle"></i> Password Update</h4>
                        <p>Leave password fields empty to keep the current password. Fill both fields to change the password.</p>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-gray-400"></i>
                                New Password
                            </label>
                            <input type="password" name="password" class="form-control @error('password') error @enderror" 
                                   placeholder="Enter new password (leave empty to keep current)">
                            @error('password')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                            <p class="help-text">Minimum 6 characters</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-gray-400"></i>
                                Confirm New Password
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   placeholder="Confirm new password">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-address-card text-blue-600"></i>
                        Personal Information
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone text-gray-400"></i>
                                Phone Number
                            </label>
                            <input type="text" name="phone" class="form-control @error('phone') error @enderror" 
                                   value="{{ old('phone', $user->phone) }}" 
                                   placeholder="Enter phone number">
                            @error('phone')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-venus-mars text-gray-400"></i>
                                Gender
                            </label>
                            <select name="gender" class="form-control @error('gender') error @enderror">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-calendar text-gray-400"></i>
                            Date of Birth
                        </label>
                        <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') error @enderror" 
                               value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}" 
                               max="{{ date('Y-m-d', strtotime('-10 years')) }}">
                        @error('date_of_birth')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                            Address
                        </label>
                        <textarea name="address" class="form-control @error('address') error @enderror" 
                                  rows="3" placeholder="Enter address">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                        Academic Information
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-building text-gray-400"></i>
                                Department
                            </label>
                            <input type="text" name="department" class="form-control @error('department') error @enderror" 
                                   value="{{ old('department', $user->department) }}" 
                                   placeholder="Enter department">
                            @error('department')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-university text-gray-400"></i>
                                Faculty
                            </label>
                            <input type="text" name="faculty" class="form-control @error('faculty') error @enderror" 
                                   value="{{ old('faculty', $user->faculty) }}" 
                                   placeholder="Enter faculty">
                            @error('faculty')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

          <!-- Profile Picture -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-image text-blue-600"></i>
                        Profile Picture
                    </h2>
                </div>
                <div class="card-content">
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-upload text-gray-400"></i>
                            {{ $user->avatar ? 'Replace Avatar (Optional)' : 'Upload Avatar (Optional)' }}
                        </label>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                            {{ $user->avatar ? 'Leave empty to keep current avatar. Upload a new image to replace it.' : 'Upload a profile picture for the user' }}
                            (JPG, PNG, GIF - Max 2MB)
                        </p>
                        
                        <div class="file-upload-area" onclick="document.getElementById('avatar').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #9ca3af; margin-bottom: 1rem;"></i>
                            <p style="margin: 0; font-weight: 500; color: #374151;">Click to select image</p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem; color: #6b7280;">or drag and drop</p>
                        </div>
                        
                        <input type="file" id="avatar" name="avatar" class="form-control @error('avatar') error @enderror" 
                               accept="image/jpeg,image/png,image/jpg,image/gif" style="display: none;">
                        
                        @error('avatar')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                        
                        <div id="imagePreview" class="hidden" style="margin-top: 1rem;">
                            <p style="font-size: 0.875rem; color: #374151; margin-bottom: 0.5rem;">Preview:</p>
                            <img id="previewImg" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #e5e7eb;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.users') }}" class="btn-gray">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="btn-success">
                    <i class="fas fa-save"></i>
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Role-specific field visibility
    const roleSelect = document.getElementById('roleSelect');
    const studentFields = document.getElementById('studentFields');
    const staffFields = document.getElementById('staffFields');
    const adminFields = document.getElementById('adminFields');

    function toggleRoleFields() {
        const selectedRole = roleSelect.value;
        
        // Hide all role-specific sections
        studentFields.classList.remove('show');
        staffFields.classList.remove('show');
        adminFields.classList.remove('show');
        
        // Show relevant section
        if (selectedRole === 'student') {
            studentFields.classList.add('show');
        } else if (selectedRole === 'staff') {
            staffFields.classList.add('show');
        } else if (selectedRole === 'admin') {
            adminFields.classList.add('show');
        }
    }

    roleSelect.addEventListener('change', toggleRoleFields);

    // File upload handling
    const fileInput = document.getElementById('avatar');
    const uploadArea = document.querySelector('.file-upload-area');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleFilePreview(file);
        }
    });

    // Handle drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                fileInput.files = files;
                handleFilePreview(file);
            }
        }
    });

    function handleFilePreview(file) {
        // Validate file size (2MB = 2048KB)
        if (file.size > 2048 * 1024) {
            alert('File size must be less than 2MB');
            fileInput.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG, GIF)');
            fileInput.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const role = roleSelect.value;
        let isValid = true;
        let errorMessage = '';

        // Role-specific validation
        if (role === 'student') {
            const matricNumber = document.querySelector('input[name="matric_number"]').value;
            const level = document.querySelector('select[name="level"]').value;
            
            if (!matricNumber.trim()) {
                isValid = false;
                errorMessage += 'Matriculation number is required for students.\n';
            }
            if (!level) {
                isValid = false;
                errorMessage += 'Level is required for students.\n';
            }
        } else if (role === 'staff' || role === 'admin') {
            const staffId = document.querySelector('input[name="staff_id"]').value;
            
            if (!staffId.trim()) {
                isValid = false;
                errorMessage += 'Staff ID is required for staff and admin users.\n';
            }
        }

        // Password validation
        const password = document.querySelector('input[name="password"]').value;
        const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;
        
        if (password && password !== passwordConfirmation) {
            isValid = false;
            errorMessage += 'Password confirmation does not match.\n';
        }

        if (password && password.length < 6) {
            isValid = false;
            errorMessage += 'Password must be at least 6 characters long.\n';
        }

        if (!isValid) {
            e.preventDefault();
            alert(errorMessage);
        }
    });

    // Auto-format phone number
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 0) {
                if (value.length <= 3) {
                    value = value;
                } else if (value.length <= 6) {
                    value = value.slice(0, 3) + '-' + value.slice(3);
                } else {
                    value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
                }
            }
            e.target.value = value;
        });
    }

    // Auto-capitalize names
    const nameInput = document.querySelector('input[name="name"]');
    if (nameInput) {
        nameInput.addEventListener('blur', function(e) {
            const words = e.target.value.split(' ');
            const capitalizedWords = words.map(word => 
                word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()
            );
            e.target.value = capitalizedWords.join(' ');
        });
    }

    // Prevent self-deactivation warning
    @if($user->id === Auth::id())
    const statusSelect = document.querySelector('select[name="status"]');
    if (statusSelect) {
        statusSelect.addEventListener('change', function(e) {
            if (e.target.value === 'inactive') {
                if (!confirm('Warning: You are about to deactivate your own account. This may prevent you from logging in. Are you sure?')) {
                    e.target.value = 'active';
                }
            }
        });
    }
    @endif
});
</script>

@endsection