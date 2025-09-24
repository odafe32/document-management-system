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

    .create-container {
        min-height: 100vh;
        background-color: #f8fafc;
        padding: 2rem 0;
    }

    .create-wrapper {
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
    }
</style>

<div class="create-container">
    <div class="create-wrapper">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-content">
                <div class="page-title">
                    <i class="fas fa-user-plus" style="font-size: 2rem;"></i>
                    <h1 style="color: #fff;">Create User</h1>
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

        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Basic Information
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
                                   value="{{ old('name') }}" required 
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
                                   value="{{ old('email') }}" required 
                                   placeholder="Enter email address">
                            @error('email')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-gray-400"></i>
                                Password <span class="required">*</span>
                            </label>
                            <input type="password" name="password" class="form-control @error('password') error @enderror" 
                                   required placeholder="Enter password">
                            @error('password')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                            <p class="help-text">Minimum 6 characters</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock text-gray-400"></i>
                                Confirm Password <span class="required">*</span>
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" 
                                   required placeholder="Confirm password">
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
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Member</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
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
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Role-specific fields -->
                    <div id="studentFields" class="role-specific">
                        <h3><i class="fas fa-user-graduate"></i> Student Information</h3>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-id-card text-gray-400"></i>
                                    Matriculation Number <span class="required">*</span>
                                </label>
                                <input type="text" name="matric_number" class="form-control @error('matric_number') error @enderror" 
                                       value="{{ old('matric_number') }}" 
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
                                    <option value="100" {{ old('level') == '100' ? 'selected' : '' }}>100 Level</option>
                                    <option value="200" {{ old('level') == '200' ? 'selected' : '' }}>200 Level</option>
                                    <option value="300" {{ old('level') == '300' ? 'selected' : '' }}>300 Level</option>
                                    <option value="400" {{ old('level') == '400' ? 'selected' : '' }}>400 Level</option>
                                    <option value="500" {{ old('level') == '500' ? 'selected' : '' }}>500 Level</option>
                                    <option value="600" {{ old('level') == '600' ? 'selected' : '' }}>600 Level</option>
                                </select>
                                @error('level')
                                    <p class="text-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div id="staffFields" class="role-specific">
                        <h3><i class="fas fa-chalkboard-teacher"></i> Staff Information</h3>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-id-badge text-gray-400"></i>
                                Staff ID <span class="required">*</span>
                            </label>
                            <input type="text" name="staff_id" class="form-control @error('staff_id') error @enderror" 
                                   value="{{ old('staff_id') }}" 
                                   placeholder="Enter staff ID">
                            @error('staff_id')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div id="adminFields" class="role-specific">
                        <h3><i class="fas fa-user-shield"></i> Administrator Information</h3>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-id-badge text-gray-400"></i>
                                Staff ID <span class="required">*</span>
                            </label>
                            <input type="text" name="staff_id" class="form-control @error('staff_id') error @enderror" 
                                   value="{{ old('staff_id') }}" 
                                   placeholder="Enter staff ID">
                            @error('staff_id')
                                <p class="text-error">{{ $message }}</p>
                            @enderror
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
                                   value="{{ old('phone') }}" 
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
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
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
                               value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d', strtotime('-10 years')) }}">
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
                                  rows="3" placeholder="Enter address">{{ old('address') }}</textarea>
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
                                   value="{{ old('department') }}" 
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
                                   value="{{ old('faculty') }}" 
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
                            Upload Avatar (Optional)
                        </label>
                        <p style="font-size: 0.875rem; color: #6b7280; margin-bottom: 1rem;">
                            Upload a profile picture for the user (JPG, PNG, GIF - Max 2MB)
                        </p>
                        
                        <div class="file-upload-area" onclick="document.getElementById('avatarInput').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2rem; color: #6b7280; margin-bottom: 0.5rem;"></i>
                            <p style="margin: 0; color: #6b7280;">Click to select image or drag and drop</p>
                            <p style="margin: 0; font-size: 0.75rem; color: #9ca3af;">Max size: 2MB</p>
                        </div>
                        <input type="file" id="avatarInput" name="avatar" class="hidden" 
                               accept="image/jpeg,image/png,image/jpg,image/gif">
                        <div id="avatarName" style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;"></div>
                        @error('avatar')
                            <p class="text-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.users') }}" class="btn-gray">
                    <i class="fas fa-times"></i>Cancel
                </a>
                <button type="submit" class="btn-success">
                    <i class="fas fa-user-plus"></i>Create User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Role-specific field handling
    document.getElementById('roleSelect').addEventListener('change', function() {
        const role = this.value;
        const studentFields = document.getElementById('studentFields');
        const staffFields = document.getElementById('staffFields');
        const adminFields = document.getElementById('adminFields');
        
        // Hide all role-specific fields
        studentFields.classList.remove('show');
        staffFields.classList.remove('show');
        adminFields.classList.remove('show');
        
        // Show relevant fields based on role
        if (role === 'student') {
            studentFields.classList.add('show');
        } else if (role === 'staff') {
            staffFields.classList.add('show');
        } else if (role === 'admin') {
            adminFields.classList.add('show');
        }
        
        // Update required fields
        updateRequiredFields(role);
    });

    function updateRequiredFields(role) {
        const matricField = document.querySelector('input[name="matric_number"]');
        const levelField = document.querySelector('select[name="level"]');
        const staffIdFields = document.querySelectorAll('input[name="staff_id"]');
        
        // Reset all required attributes
        if (matricField) matricField.removeAttribute('required');
        if (levelField) levelField.removeAttribute('required');
        staffIdFields.forEach(field => field.removeAttribute('required'));
        
        // Set required based on role
        if (role === 'student') {
            if (matricField) matricField.setAttribute('required', 'required');
            if (levelField) levelField.setAttribute('required', 'required');
        } else if (role === 'staff' || role === 'admin') {
            staffIdFields.forEach(field => {
                if (field.closest('.role-specific').classList.contains('show')) {
                    field.setAttribute('required', 'required');
                }
            });
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('roleSelect');
        if (roleSelect.value) {
            roleSelect.dispatchEvent(new Event('change'));
        }
    });

    // Avatar upload handling
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        const avatarNameDiv = document.getElementById('avatarName');
        if (fileName) {
            avatarNameDiv.textContent = `Selected: ${fileName}`;
            avatarNameDiv.style.color = '#059669';
            avatarNameDiv.style.fontWeight = '500';
        } else {
            avatarNameDiv.textContent = '';
        }
    });

    // Drag and drop functionality
    const uploadArea = document.querySelector('.file-upload-area');
    
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('avatarInput').files = files;
            document.getElementById('avatarName').textContent = `Selected: ${files[0].name}`;
            document.getElementById('avatarName').style.color = '#059669';
            document.getElementById('avatarName').style.fontWeight = '500';
        }
    });

    // Form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="name"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value;
        const passwordConfirm = document.querySelector('input[name="password_confirmation"]').value;
        const role = document.querySelector('select[name="role"]').value;
        const status = document.querySelector('select[name="status"]').value;

        if (!name || !email || !password || !passwordConfirm || !role || !status) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return false;
        }

        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('Passwords do not match.');
            return false;
        }

        // Role-specific validation
        if (role === 'student') {
            const matricNumber = document.querySelector('input[name="matric_number"]').value.trim();
            const level = document.querySelector('select[name="level"]').value;
            if (!matricNumber || !level) {
                e.preventDefault();
                alert('Please fill in all student-specific fields.');
                return false;
            }
        } else if (role === 'staff' || role === 'admin') {
            const staffId = document.querySelector('.role-specific.show input[name="staff_id"]').value.trim();
            if (!staffId) {
                e.preventDefault();
                alert('Please fill in the staff ID.');
                return false;
            }
        }

        // Show loading state
        const submitBtn = document.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Creating User...';
    });
</script>

@endsection