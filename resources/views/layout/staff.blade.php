<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="brand" data-topbar-color="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $meta_title }}</title>

    <!-- Updated Meta Description -->
    <meta name="description" content="Departmental Information Management System for managing documents, announcements, staff profiles, and student feedback in one centralized platform.">

    <meta name="author" content="Nsuk Document Management System" />
    <meta content="Departmental Information Management System with document management and announcements" name="description" />
    <meta content="{{ $meta_title }}" property="og:title" />
    <meta content="Departmental Information Management System for managing documents, announcements, staff profiles, and communication." property="og:description" />
    <meta content="{{ $meta_title }}" property="twitter:title" />
    <meta content="Centralized departmental portal with document management, announcements, staff directory, and student feedback." property="twitter:description" />
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
            background-color: #d1fae5 !important;
            border: 1px solid #10b981 !important;
            color: #065f46 !important;
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
                            <a class="eskimo-logo-link" href="{{ route('staff.dashboard') }}">
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
                                    <li><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                                    <li><a href="{{ route('staff.profile') }}">Profile</a></li>
                                    <li><a href="{{ route('staff.documents') }}">My Documents</a></li>
                                    <li><a href="{{ route('staff.announcements') }}">My Announcements</a></li>
                                    <li><a href="{{ route('staff.feedbacks') }}">Feedbacks</a></li>
                                </ul>
                            </nav>
                        </div>
                       
                    </div>
                </div>
                
                
                <!-- CONTENT SECTION -->
                @yield('content')
                
            </div>
        </main>

        <!-- FOOTER -->
        <footer id="eskimo-footer">
            <div class="container">
                <div class="row eskimo-footer-wrapper">
                    <!-- FOOTER WIDGET 1 -->
                    <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                        <h5 class="eskimo-title-with-border"><span>About Department</span></h5>
                        <p>Departmental Information Management System for managing documents, announcements, staff profiles, and student feedback in one centralized platform.</p>
                        <p><a href="{{ route('staff.profile') }}" class="btn btn-default">Read More</a></p>
                    </div>
                    <!-- FOOTER WIDGET 2 -->
                    <div class="col-12 col-lg-6">
                        <h5 class="eskimo-title-with-border"><span>Quick Links</span></h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('staff.documents') }}">Documents</a></li>
                            <li><a href="{{ route('staff.announcements') }}">Announcements</a></li>
                            <li><a href="{{ route('staff.feedbacks') }}">Feedbacks</a></li>
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