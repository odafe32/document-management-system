<!DOCTYPE html>
    <html lang="en" data-bs-theme="light" data-menu-color="brand" data-topbar-color="light">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>{{ $meta_title }}</title>
    
        <!-- Updated Meta Description -->
        <meta name="description" content="Departmental Information Management System for managing documents, announcements, admin profiles, and student feedback in one centralized platform.">
    
        <meta name="author" content="Nsuk Document Management System" />
        <meta content="Departmental Information Management System with document management and announcements" name="description" />
        <meta content="{{ $meta_title }}" property="og:title" />
        <meta content="Departmental Information Management System for managing documents, announcements, admin profiles, and communication." property="og:description" />
        <meta content="{{ $meta_title }}" property="twitter:title" />
        <meta content="Centralized departmental portal with document management, announcements, admin directory, and student feedback." property="twitter:description" />
        <meta content="{{ $meta_image }}" property="og:image" />
        <meta content="{{ $meta_image }}" property="twitter:image" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta property="og:type" content="website" />
        <meta content="summary_large_image" name="twitter:card" />
        <meta content="Departmental Information Management System" name="generator" />
    
        <!-- favicon -->
        <link rel="shortcut icon" href="{{ url('logo.png') }}" />
    
        <link href="{{ url('app/css/bootstrap.min.css?v=' .env('CACHE_VERSION')) }}" rel="stylesheet" type="text/css">
        <link href="{{ url('app/css/fontawesome.css?v=' .env('CACHE_VERSION')) }}" rel="stylesheet" type="text/css">
        <link href="{{ url('app/css/slick.css?v=' .env('CACHE_VERSION')) }}" rel="stylesheet" type="text/css">
        <link href="{{ url('app/css/style.css?v=' .env('CACHE_VERSION')) }}" rel="stylesheet" type="text/css">
    
        <style>
            /* Works on Firefox */
            * {
                scrollbar-width: thin;
                scrollbar-color: #123524 transparent;
            }
    
            /* Works on Chrome, Edge, and Safari */
            *::-webkit-scrollbar {
                width: 5px !important;
                height: 5px !important;
            }
    
            *::-webkit-scrollbar-track {
                background: transparent !important;
            }
    
            *::-webkit-scrollbar-thumb {
                background-color: #123524 !important;
                border-radius: 20px !important;
                border: 3px solid transparent !important;
            }
    
            .iti,
            .country-select {
                display: block !important;
            }
    
            .menu-item:hover {
                background-color: rgba(255, 255, 255, 0.1);
            }
    
            .menu-item.active {
                background-color: rgba(255, 255, 255, 0.1);
            }
    
            .menu-item {
                list-style: none;
                margin-left: -30px;
            }
    
            .menu-title {
                list-style: none;
                margin-left: -30px;
            }
    
            /* Custom Alert Styles - High Specificity to Override Existing CSS */
            .custom-alert-success {
                background-color: #005f2e !important;
                border: 1px solid #000e09 !important;
                color: #000000 !important;
                padding: 12px 16px !important;
                border-radius: 8px !important;
                margin-top: 16px !important;
                font-size: 14px !important;
                display: block !important;
            }
    
            .custom-alert-error {
                background-color: #fee2e2 !important;
                border: 1px solid #ef4444 !important;
                color: #991b1b !important;
                padding: 12px 16px !important;
                border-radius: 8px !important;
                margin-top: 16px !important;
                font-size: 14px !important;
                display: block !important;
            }
    
            .custom-alert-error ul {
                margin: 0 !important;
                padding-left: 20px !important;
                list-style-type: disc !important;
            }
    
            .custom-alert-error li {
                margin: 4px 0 !important;
                color: #991b1b !important;
            }
    
            /* Custom Input Error Styles */
            .custom-input-error {
                border-color: #ef4444 !important;
                border-width: 1px !important;
            }
    
            .custom-input-error:focus {
                border-color: #ef4444 !important;
                box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
            }
    
            .custom-error-text {
                color: #ef4444 !important;
                font-size: 12px !important;
                margin-top: 4px !important;
                display: block !important;
            }
    
            /* Custom Button Styles */
            .custom-btn-primary {
                background-color: darkgreen !important;
                color: white !important;
                padding: 10px 24px !important;
                border-radius: 8px !important;
                font-size: 14px !important;
                border: none !important;
                cursor: pointer !important;
                transition: all 0.2s ease !important;
                display: inline-flex !important;
                align-items: center !important;
                gap: 8px !important;
            }
    
            .custom-btn-primary:hover {
                background-color: #006400 !important;
            }
    
            .custom-btn-primary:disabled {
                opacity: 0.5 !important;
                cursor: not-allowed !important;
            }
    
            /* Custom Spinner */
            .custom-spinner {
                animation: spin 1s linear infinite !important;
                width: 16px !important;
                height: 16px !important;
                display: none !important;
            }
    
            .custom-spinner.show {
                display: inline-block !important;
            }
    
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
    
            /* Form Input Styles */
            .custom-input {
                width: 100% !important;
                padding: 10px 16px !important;
                border: 1px solid #d1d5db !important;
                border-radius: 8px !important;
                font-size: 14px !important;
                color: #6b7280 !important;
                background-color: white !important;
            }
    
            .custom-input:focus {
                outline: none !important;
                border-color: #9ca3af !important;
            }
    
            .custom-label {
                display: block !important;
                font-weight: 500 !important;
                font-size: 14px !important;
                margin-bottom: 8px !important;
                color: #374151 !important;
            }
    
            /* Demo Credentials Box */
            .demo-credentials {
                margin-top: 32px !important;
                padding: 16px !important;
                background-color: #f9fafb !important;
                border-radius: 8px !important;
                border: 1px solid #e5e7eb !important;
            }
    
            .demo-credentials h3 {
                font-size: 14px !important;
                font-weight: 500 !important;
                color: #374151 !important;
                margin-bottom: 8px !important;
            }
    
            .demo-credentials p {
                font-size: 12px !important;
                color: #6b7280 !important;
                margin: 4px 0 !important;
            }
    
            /* Checkbox Styles */
            .custom-checkbox {
                width: 16px !important;
                height: 16px !important;
                accent-color: darkgreen !important;
            }
    
            .custom-checkbox-label {
                margin-left: 8px !important;
                font-size: 14px !important;
                color: #374151 !important;
            }
    
            /* Ensure content section has proper spacing from sidebar */
            #eskimo-main-container .container {
                position: relative;
            }
    
            /* Top icons positioning fix */
            .eskimo-top-icons {
                position: relative;
                z-index: 10;
            }

            /* Content area adjustments for topbar */
            #eskimo-content-cell {
                padding-top: 0 !important;
            }

            /* Topbar Styles */
            #eskimo-topbar {
                background: #ffffff;
                border-bottom: 1px solid #e5e7eb;
                padding: 12px 24px;
                position: sticky;
                top: 0;
                z-index: 1000;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .eskimo-topbar-wrapper {
                max-width: 100%;
            }

            .eskimo-topbar-title {
                color: #374151;
                font-weight: 600;
                font-size: 18px;
            }

            /* Profile Dropdown Container */
            .profile-dropdown-container {
                position: relative;
                display: inline-block;
            }

            /* Profile Button Styles */
            .profile-btn {
                background: transparent;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                padding: 8px 12px;
                cursor: pointer;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                gap: 2px;
                text-decoration: none;
                color: inherit;
            }

            .profile-btn:hover {
                background: #f9fafb;
                border-color: #d1d5db;
                text-decoration: none;
                color: inherit;
            }

            .profile-btn:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            /* Profile Avatar Styles */
            .profile-avatar {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .avatar-img {
                width: 50%;
                height: 50%;
                object-fit: cover;
                border-radius: 50%
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
                font-size: 14px;
            }

            /* Profile Details */
            .profile-details {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                margin-left: 8px;
            }

            .profile-name {
                font-weight: 500;
                font-size: 14px;
                color: #374151;
                line-height: 1.2;
            }

            .profile-role {
                font-size: 12px;
                color: #6b7280;
                line-height: 1.2;
            }

            /* Dropdown Arrow */
            .dropdown-arrow {
                font-size: 12px;
                color: #6b7280;
                margin-left: 8px;
                transition: transform 0.2s ease;
            }

            .profile-dropdown-container.active .dropdown-arrow {
                transform: rotate(180deg);
            }

            /* Dropdown Menu Styles */
            .profile-dropdown-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background: white;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
                padding: 8px 0;
                min-width: 250px;
                margin-top: 8px;
                z-index: 1050;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.2s ease;
            }

            .profile-dropdown-container.active .profile-dropdown-menu {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            /* Dropdown Header */
            .dropdown-header {
                padding: 12px 16px;
                background: #f9fafb;
                margin-bottom: 4px;
            }

            .profile-avatar-small {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 12px;
            }

            .avatar-img-small {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .avatar-placeholder-small {
                width: 100%;
                height: 100%;
                background: darkgreen;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                font-size: 16px;
            }

            .profile-details-small {
                flex: 1;
            }

            .profile-name-small {
                font-weight: 600;
                font-size: 14px;
                color: #374151;
                margin-bottom: 2px;
            }

            .profile-email-small {
                font-size: 12px;
                color: #6b7280;
            }

            /* Dropdown Items */
            .dropdown-item {
                padding: 10px 16px;
                font-size: 14px;
                color: #374151;
                display: flex;
                align-items: center;
                transition: all 0.2s ease;
                border: none;
                background: none;
                width: 100%;
                text-align: left;
                text-decoration: none;
                cursor: pointer;
            }

            .dropdown-item:hover {
                background: #f3f4f6;
                color: #111827;
                text-decoration: none;
            }

            .dropdown-item i {
                width: 16px;
                color: #6b7280;
                margin-right: 8px;
            }

            .logout-btn:hover {
                background: #fef2f2;
                color: #dc2626;
            }

            .logout-btn:hover i {
                color: #dc2626;
            }

            .dropdown-divider {
                height: 0;
                margin: 4px 0;
                overflow: hidden;
                border-top: 1px solid #e5e7eb;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                #eskimo-topbar {
                    padding: 8px 16px;
                }
                
                .eskimo-topbar-title {
                    font-size: 16px;
                }
                
                .profile-dropdown-menu {
                    min-width: 200px;
                }
            }
    
        </style>
    
    </head>
    
    <body>
        {{ csrf_field() }}
        
        <!-- READING POSITION INDICATOR -->
        <progress value="0" id="eskimo-progress-bar">
            <span class="eskimo-progress-container">
                <span class="eskimo-progress-bar"></span>
            </span>
        </progress>
    
        <!-- SITE WRAPPER -->
        <div id="eskimo-site-wrapper">
            <!-- MAIN CONTAINER -->
            <main id="eskimo-main-container">
                <div class="container">
                    <!-- SIDEBAR -->
                    <div id="eskimo-sidebar">
                        <div id="eskimo-sidebar-wrapper" class="d-flex align-items-start flex-column h-100 w-100">
                            <!-- LOGO -->
                            <div id="eskimo-logo-cell" class="w-100">
                                <a class="eskimo-logo-link" href="{{ route('admin.dashboard') }}">
                                    <img src="{{ url('logo.png') }}" style="width: 100px" class="eskimo-logo" alt="logo" />
                                </a>
                            </div>
                            <!-- MENU CONTAINER -->
                            <div id="eskimo-sidebar-cell" class="w-100">
                                <!-- MOBILE MENU BUTTON -->
                                <div id="eskimo-menu-toggle">MENU</div>
                                <!-- MENU -->
                                <nav id="eskimo-main-menu" class="menu-main-menu-container">
                                    <ul class="eskimo-menu-ul">
                                        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        <li><a href="{{ route('admin.users') }}">Users</a></li>
                                        <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                                        <li><a href="{{ route('admin.documents') }}">My Documents</a></li>
                                        
                                        <li><a href="{{ route('admin.announcements') }}">My Announcements</a></li>
                                        <li><a href="{{ route('admin.feedbacks') }}">Feedbacks</a></li>
                                    </ul>
                                </nav>
                            </div>
                           
                        </div>
                    </div>
                    
                    <!-- CONTENT SECTION -->
                    <div id="eskimo-content-cell" class="w-100">
                        <!-- TOPBAR -->
                        @auth
                        <div id="eskimo-topbar" class="w-100">
                            <div class="eskimo-topbar-wrapper d-flex justify-content-between align-items-center">
                                <!-- Left side - Page title or breadcrumb -->
                                <div class="eskimo-topbar-left">
                                    <h4 class="eskimo-topbar-title mb-0">{{ $pageTitle ?? 'Dashboard' }}</h4>
                                </div>
                                
                                <!-- Right side - Profile dropdown -->
                                <div class="eskimo-topbar-right">
                                    <div class="profile-dropdown-container" id="profileDropdownContainer">
                                        <button class="profile-btn" style="border: none" type="button" id="profileDropdownBtn">
                                            <div class="d-flex align-items-center">
                                                <!-- Profile Image -->
                                                <div class="profile-avatar">
                                                    @if(Auth::user()->avatar)
                                                        <img src="{{ Storage::url(Auth::user()->avatar) }}"  alt="{{ Auth::user()->name }}" class="avatar-img">
                                                    @else
                                                        <div class="avatar-placeholder">
                                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                <!-- Profile Details -->
                                                <div class="profile-details d-none d-md-block">
                                                    <span class="profile-name">{{ Auth::user()->name }}</span>
                                                    <small class="profile-role">{{ ucfirst(Auth::user()->role) }}</small>
                                                </div>
                                                
                                                <!-- Dropdown Arrow -->
                                                <i class="fas fa-chevron-down dropdown-arrow"></i>
                                            </div>
                                        </button>
                                        
                                        <!-- Dropdown Menu -->
                                        <div class="profile-dropdown-menu">
                                            <div class="dropdown-header">
                                                <div class="d-flex align-items-center">
                                                    <div class="profile-avatar-small">
                                                        @if(Auth::user()->avatar)
                                                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="avatar-img-small">
                                                        @else
                                                            <div class="avatar-placeholder-small">
                                                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="profile-details-small">
                                                        <div class="profile-name-small">{{ Auth::user()->name }}</div>
                                                        <div class="profile-email-small">{{ Auth::user()->email }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                                <i class="fas fa-user"></i>
                                                View Profile
                                            </a>
                                           
                                            <div class="dropdown-divider"></div>
                                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                                @csrf
                                                <button type="submit" class="dropdown-item logout-btn">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                    Logout
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endauth
                        
                        <!-- PAGE CONTENT -->
                        @yield('content')
                    </div>
                    
                </div>
            </main>
    
            <!-- FOOTER -->
            <footer id="eskimo-footer">
                <div class="container">
                    <div class="row eskimo-footer-wrapper">
                        <!-- FOOTER WIDGET 1 -->
                        <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                            <h5 class="eskimo-title-with-border"><span>About Department</span></h5>
                            <p>Departmental Information Management System for managing documents, announcements, admin profiles, and student feedback in one centralized platform.</p>
                            <p><a href="{{ route('admin.profile') }}" class="btn btn-default">Read More</a></p>
                        </div>
                        <!-- FOOTER WIDGET 2 -->
                        <div class="col-12 col-lg-6">
                            <h5 class="eskimo-title-with-border"><span>Quick Links</span></h5>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('admin.documents') }}">Documents</a></li>
                                <li><a href="{{ route('admin.announcements') }}">Announcements</a></li>
                                <li><a href="{{ route('admin.feedbacks') }}">Feedbacks</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- CREDITS -->
                    <div class="eskimo-footer-credits">
                        <p>
                            Made with love by <a href="" target="_blank">Odafe Godfrey</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    
    
        <!-- SLIDE PANEL OVERLAY -->
        <div id="eskimo-overlay"></div>
        
        
        <!-- JS FILES -->
        <script src="{{ url('app/js/jquery-3.3.1.min.js?v=' .env('CACHE_VERSION')) }}"></script>
        <script src="{{ url('app/js/bootstrap.min.js?v=' .env('CACHE_VERSION')) }}"></script>
        <script src="{{ url('app/js/salvattore.min.js?v=' .env('CACHE_VERSION')) }}"></script>
        <script src="{{ url('app/js/slick.min.js?v=' .env('CACHE_VERSION')) }}"></script>
        <script src="{{ url('app/js/panel.js?v=' .env('CACHE_VERSION')) }}"></script>
        <script src="{{ url('app/js/reading-position-indicator.js?v=' .env('CACHE_VERSION')) }}"></script>
        <script src="{{ url('app/js/custom.js?v=' .env('CACHE_VERSION')) }}"></script>
        
        <!-- Profile Dropdown Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdownContainer = document.getElementById('profileDropdownContainer');
                const dropdownBtn = document.getElementById('profileDropdownBtn');
                
                if (dropdownBtn && dropdownContainer) {
                    // Toggle dropdown on button click
                    dropdownBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropdownContainer.classList.toggle('active');
                    });
                    
                    // Close dropdown when clicking outside
                    document.addEventListener('click', function(e) {
                        if (!dropdownContainer.contains(e.target)) {
                            dropdownContainer.classList.remove('active');
                        }
                    });
                    
                    // Prevent dropdown from closing when clicking inside the menu
                    const dropdownMenu = dropdownContainer.querySelector('.profile-dropdown-menu');
                    if (dropdownMenu) {
                        dropdownMenu.addEventListener('click', function(e) {
                            e.stopPropagation();
                        });
                    }
                    
                    // Close dropdown when clicking on links (but not the logout button)
                    const dropdownLinks = dropdownContainer.querySelectorAll('a.dropdown-item');
                    dropdownLinks.forEach(function(link) {
                        link.addEventListener('click', function() {
                            dropdownContainer.classList.remove('active');
                        });
                    });
                }
            });
        </script>
        
        <!-- POST SLIDER -->
        <script>
            (function($) {
                "use strict";
                $(document).ready(function() {
                    if ($('#eskimo-post-slider').length) {
                        $('#eskimo-post-slider').slick({
                            autoplay: true,
                            autoplaySpeed: 5000,
                            slidesToScroll: 1,
                            adaptiveHeight: true,
                            slidesToShow: 1,
                            arrows: true,
                            dots: false,
                            fade: true
                        });
                    }
                });
                $(window).on('load', function() {
                    $('#eskimo-post-slider').css('opacity', '1');
                    $('#eskimo-post-slider').parent().removeClass('eskimo-bg-loader');
                });
            })(jQuery);

             // Set up CSRF token for all AJAX requests
            document.addEventListener('DOMContentLoaded', function() {
                const token = document.querySelector('meta[name="csrf-token"]');
                if (token) {
                    window.axios = window.axios || {};
                    window.axios.defaults = window.axios.defaults || {};
                    window.axios.defaults.headers = window.axios.defaults.headers || {};
                    window.axios.defaults.headers.common = window.axios.defaults.headers.common || {};
                    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.getAttribute('content');
                }
            });

        </script>
        
        <!-- POST CAROUSEL -->
        <script>
            (function($) {
                "use strict";
                $(document).ready(function() {
                    if ($('#eskimo-post-carousel').length) {
                        $('#eskimo-post-carousel').slick({
                            infinite: false,
                            slidesToScroll: 1,
                            arrows: true,
                            dots: false,
                            slidesToShow: 3,
                            responsive: [{
                                breakpoint: 992,
                                settings: {
                                    slidesToShow: 2
                                }
                            }, {
                                breakpoint: 576,
                                settings: {
                                    slidesToShow: 1
                                }
                            }]
                        });
                        $('#eskimo-post-carousel').css('opacity', '1');
                    }
                });
            })(jQuery);
        </script>
    </body>
    </html>