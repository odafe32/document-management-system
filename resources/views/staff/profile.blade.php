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

    .profile-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .profile-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .profile-header {
        background: darkgreen;
        border-radius: 20px;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .profile-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 2rem;
    }

    .avatar-section {
        position: relative;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .avatar-overlay:hover {
        opacity: 1;
    }

    .status-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #10b981;
        border-radius: 50%;
        padding: 8px;
        border: 3px solid white;
    }

    .profile-info h1 {
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0;
        margin-bottom: 0.5rem;
    }

    .profile-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .profile-meta p {
        font-size: 1.125rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin: 0;
    }

    .status-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 500;
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
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: #4b5563;
        transform: translateY(-1px);
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

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
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

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #374151;
    }

    .form-control {
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

    .form-control.readonly {
        background: #f3f4f6;
        color: #6b7280;
    }

    .view-mode .form-display {
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 8px;
        color: #374151;
        border: 2px solid transparent;
    }

    .edit-mode {
        display: none;
    }

    .edit-mode.active {
        display: block;
    }

    .view-mode.hidden {
        display: none;
    }

    .sidebar-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .stats-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .stats-item:last-child {
        border-bottom: none;
    }

    .stats-label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6b7280;
        font-weight: 500;
    }

    .stats-value {
        font-weight: 600;
        color: #111827;
    }

    .status-badge-inline {
        padding: 0.25rem 0.75rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .form-actions {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }

    .hidden {
        display: none !important;
    }

    .text-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-wrapper">
        
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-header-content">
                <div class="avatar-section">
                    <img id="avatar-preview" 
                         src="{{ $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF' }}" 
                         alt="Profile Picture" 
                         class="profile-avatar">
                    
                    <div id="avatar-overlay" class="avatar-overlay hidden" onclick="document.getElementById('avatar').click()">
                        <i class="fas fa-camera text-white text-2xl"></i>
                    </div>
                    
                    <div class="status-badge">
                        <i class="fas fa-check text-white text-sm"></i>
                    </div>
                </div>
                
                <div class="profile-info">
                    <h1 style="color: #fff;">{{ $user->name }}</h1>
                    <div class="profile-meta">
                        <p><i class="fas fa-id-badge"></i>{{ $user->staff_id }}</p>
                        <p><i class="fas fa-building"></i>{{ $user->department ?? 'Department not assigned' }}</p>
                    </div>
                    <div class="status-indicator">
                        <i class="fas fa-circle" style="font-size: 8px;"></i>
                        {{ ucfirst($user->status) }}
                    </div>
                </div>
                
                <div style="margin-left: auto;">
                    <button id="editToggle" class="btn-primary">
                        <i class="fas fa-edit"></i>Edit Profile
                    </button>
                    <button id="cancelEdit" class="btn-secondary hidden">
                        <i class="fas fa-times"></i>Cancel
                    </button>
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

        <form id="profileForm" action="{{ route('staff.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Hidden file input -->
            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewImage(this)">

            <div class="content-grid">
                
                <!-- Left Column -->
                <div>
                    
                    <!-- Personal Information -->
                    <div class="card">
                        <div class="card-header">
                            <h2>
                                <i class="fas fa-user text-blue-600"></i>
                                Personal Information
                            </h2>
                        </div>
                        <div class="card-content">
                            <div class="form-grid">
                                
                                <!-- Full Name -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-signature text-gray-400"></i>
                                        Full Name *
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->name }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                               class="form-control @error('name') border-red-500 @enderror" required>
                                        @error('name')
                                            <p class="text-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                        Email Address *
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->email }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                               class="form-control @error('email') border-red-500 @enderror" required>
                                        @error('email')
                                            <p class="text-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-phone text-gray-400"></i>
                                        Phone Number
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->phone ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" 
                                               class="form-control @error('phone') border-red-500 @enderror" 
                                               placeholder="+234 800 000 0000">
                                        @error('phone')
                                            <p class="text-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars text-gray-400"></i>
                                        Gender
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->gender ? ucfirst($user->gender) : 'Not specified' }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <select name="gender" class="form-control @error('gender') border-red-500 @enderror">
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

                                <!-- Date of Birth -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-birthday-cake text-gray-400"></i>
                                        Date of Birth
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->date_of_birth ? $user->date_of_birth->format('F j, Y') : 'Not provided' }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <input type="date" name="date_of_birth" 
                                               value="{{ old('date_of_birth', $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '') }}" 
                                               class="form-control @error('date_of_birth') border-red-500 @enderror">
                                        @error('date_of_birth')
                                            <p class="text-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Staff ID (Read-only) -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                        Staff ID
                                    </label>
                                    <div class="form-display readonly" style="font-family: monospace;">{{ $user->staff_id }}</div>
                                    <p style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">Staff ID cannot be changed</p>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    Address
                                </label>
                                <div class="view-mode">
                                    <div class="form-display">{{ $user->address ?? 'Not provided' }}</div>
                                </div>
                                <div class="edit-mode">
                                    <textarea name="address" rows="3" 
                                              class="form-control @error('address') border-red-500 @enderror" 
                                              placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="text-error">{{ $message }}</p>
                                    @enderror
                                </div>
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
                                
                                <!-- Department -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-building text-gray-400"></i>
                                        Department
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->department ?? 'Not assigned' }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <input type="text" name="department" value="{{ old('department', $user->department) }}" 
                                               class="form-control @error('department') border-red-500 @enderror" 
                                               placeholder="e.g., Computer Science">
                                        @error('department')
                                            <p class="text-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Faculty -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-university text-gray-400"></i>
                                        Faculty
                                    </label>
                                    <div class="view-mode">
                                        <div class="form-display">{{ $user->faculty ?? 'Not assigned' }}</div>
                                    </div>
                                    <div class="edit-mode">
                                        <input type="text" name="faculty" value="{{ old('faculty', $user->faculty) }}" 
                                               class="form-control @error('faculty') border-red-500 @enderror" 
                                               placeholder="e.g., Science">
                                        @error('faculty')
                                            <p class="text-error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Role (Read-only) -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-user-tie text-gray-400"></i>
                                        Role
                                    </label>
                                    <div class="form-display readonly">{{ ucfirst($user->role) }}</div>
                                </div>

                                <!-- Last Login (Read-only) -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-clock text-gray-400"></i>
                                        Last Login
                                    </label>
                                    <div class="form-display readonly">{{ $user->last_login_at ? $user->last_login_at->format('M j, Y g:i A') : 'Never' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Password Change Section (Only in edit mode) -->
                    <div class="card edit-mode">
                        <div class="card-header">
                            <h2>
                                <i class="fas fa-lock text-blue-600"></i>
                                Change Password
                            </h2>
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 0;">Leave blank if you don't want to change your password</p>
                        </div>
                        <div class="card-content">
                            <div class="form-grid">
                                
                                <!-- Current Password -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-key text-gray-400"></i>
                                        Current Password
                                    </label>
                                    <input type="password" name="current_password" 
                                           class="form-control @error('current_password') border-red-500 @enderror" 
                                           placeholder="Enter current password">
                                    @error('current_password')
                                        <p class="text-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- New Password -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-lock text-gray-400"></i>
                                        New Password
                                    </label>
                                    <input type="password" name="new_password" 
                                           class="form-control @error('new_password') border-red-500 @enderror" 
                                           placeholder="Enter new password">
                                    @error('new_password')
                                        <p class="text-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm New Password -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-lock text-gray-400"></i>
                                        Confirm Password
                                    </label>
                                    <input type="password" name="new_password_confirmation" 
                                           class="form-control" 
                                           placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    
                    <!-- Profile Picture Management (Edit Mode) -->
                    <div class="sidebar-card edit-mode">
                        <div class="card-header">
                            <h2>
                                <i class="fas fa-camera text-blue-600"></i>
                                Profile Picture
                            </h2>
                        </div>
                        <div class="card-content" style="text-align: center;">
                            <button type="button" onclick="document.getElementById('avatar').click()" 
                                    class="btn-primary" style="background: #4f46e5; border-color: #4f46e5;">
                                <i class="fas fa-upload"></i>Upload New Picture
                            </button>
                            <p style="color: #6b7280; font-size: 0.875rem; margin: 1rem 0;">JPG, PNG or GIF. Max size 2MB.</p>
                            @if($user->avatar)
                                <button type="button" onclick="removeAvatar()" 
                                        style="background: none; border: none; color: #dc2626; font-size: 0.875rem; cursor: pointer;">
                                    <i class="fas fa-trash"></i> Remove Picture
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Account Status -->
                    <div class="sidebar-card">
                        <div class="card-header">
                            <h2>
                                <i class="fas fa-info-circle text-blue-600"></i>
                                Account Status
                            </h2>
                        </div>
                        <div class="card-content">
                            
                            <!-- Account Status -->
                            <div class="stats-item">
                                <span class="stats-label">
                                    <i class="fas fa-user-check text-gray-400"></i>
                                    Status
                                </span>
                                <span class="status-badge-inline {{ $user->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                    <i class="fas fa-circle" style="font-size: 8px;"></i>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>

                            <!-- Email Verification -->
                            <div class="stats-item">
                                <span class="stats-label">
                                    <i class="fas fa-envelope-check text-gray-400"></i>
                                    Email
                                </span>
                                @if($user->email_verified_at)
                                    <span class="status-badge-inline status-verified">
                                        <i class="fas fa-check"></i>Verified
                                    </span>
                                @else
                                    <span class="status-badge-inline status-pending">
                                        <i class="fas fa-clock"></i>Pending
                                    </span>
                                @endif
                            </div>

                            <!-- Member Since -->
                            <div class="stats-item">
                                <span class="stats-label">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                    Member Since
                                </span>
                                <span class="stats-value">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="sidebar-card">
                        <div class="card-header">
                            <h2>
                                <i class="fas fa-chart-bar text-blue-600"></i>
                                Quick Stats
                            </h2>
                        </div>
                        <div class="card-content">
                            <div class="stats-item">
                                <span class="stats-label">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                    Documents
                                </span>
                                <span class="stats-value">0</span>
                            </div>
                            
                            <div class="stats-item">
                                <span class="stats-label">
                                    <i class="fas fa-bullhorn text-gray-400"></i>
                                    Announcements
                                </span>
                                <span class="stats-value">0</span>
                            </div>
                            
                            <div class="stats-item">
                                <span class="stats-label">
                                    <i class="fas fa-comments text-gray-400"></i>
                                    Feedbacks
                                </span>
                                <span class="stats-value">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons (Only visible in edit mode) -->
            <div class="edit-mode">
                <div class="form-actions">
                    <button type="button" id="cancelEditBtn" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" id="updateButton" class="btn-success">
                        <span id="updateText">
                            <i class="fas fa-save"></i> Update Profile
                        </span>
                        <span id="updateSpinner" class="hidden">
                            <i class="fas fa-spinner fa-spin"></i>Updating...
                        </span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle between view and edit modes
    const editToggle = document.getElementById('editToggle');
    const cancelEdit = document.getElementById('cancelEdit');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const viewModes = document.querySelectorAll('.view-mode');
    const editModes = document.querySelectorAll('.edit-mode');
    const avatarOverlay = document.getElementById('avatar-overlay');

    function toggleEditMode(isEdit) {
        if (isEdit) {
            // Show edit mode
            viewModes.forEach(el => el.classList.add('hidden'));
            editModes.forEach(el => el.classList.add('active'));
            editToggle.classList.add('hidden');
            cancelEdit.classList.remove('hidden');
            avatarOverlay.classList.remove('hidden');
        } else {
            // Show view mode
            viewModes.forEach(el => el.classList.remove('hidden'));
            editModes.forEach(el => el.classList.remove('active'));
            editToggle.classList.remove('hidden');
            cancelEdit.classList.add('hidden');
            avatarOverlay.classList.add('hidden');
            
            // Reset form
            document.getElementById('profileForm').reset();
            // Reset avatar preview
            document.getElementById('avatar-preview').src = '{{ $user->avatar ? Storage::url($user->avatar) : "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&color=7F9CF5&background=EBF4FF" }}';
        }
    }

    editToggle.addEventListener('click', () => toggleEditMode(true));
    cancelEdit.addEventListener('click', () => toggleEditMode(false));
    cancelEditBtn.addEventListener('click', () => toggleEditMode(false));

    // Preview uploaded image
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove avatar
    function removeAvatar() {
        if (confirm('Are you sure you want to remove your profile picture?')) {
            document.getElementById('avatar-preview').src = 'https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF';
            document.getElementById('avatar').value = '';
        }
    }

    // Form submission loading state
    document.getElementById('profileForm').addEventListener('submit', function() {
        const button = document.getElementById('updateButton');
        const text = document.getElementById('updateText');
        const spinner = document.getElementById('updateSpinner');
        
        button.disabled = true;
        text.classList.add('hidden');
        spinner.classList.remove('hidden');
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

    // Show edit mode if there are validation errors
    @if($errors->any())
        toggleEditMode(true);
    @endif
</script>
@endsection