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
    <meta content="Esse Mobility Dashboard" name="generator" />

 

    <!-- favicon -->
    <link rel="shortcut icon" href="{{ url('logo.png') }}" />

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="../../cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referre..rpolicy="no-referrer" />

    <!-- Style css -->
    <link href="{{ url('auth/css/style.min.css?v=' .env('CACHE_VERSION')) }}" rel="stylesheet" type="text/css">

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
    </style>

</head>

<body>
    {{ csrf_field() }}
     <section class="h-screen flex items-center justify-center bg-no-repeat inset-0 bg-cover bg-[url('../images/bg.html')]">

            @yield('content')
     </section>  
</body>

</html>
