@extends('layout.auth')
@section('content')
    <div class="container 2xl:px-80 xl:px-52">
        <div class="bg-white rounded-lg p-5" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
            <div class="grid xl:grid-cols-5 lg:grid-cols-3 gap-6">

                <!-- Left Panel (Intro Section) -->
                <div class="xl:col-span-2 lg:col-span-1 hidden lg:block">
                    <div class="text-white rounded-lg flex flex-col justify-between gap-10 h-full w-full p-7" style="background-color: darkgreen;">
                        <div class="flex justify-center items-center w-full gap-2">
                            <img src="{{ url('logo.png') }}" style="width: 80px" alt="NSUK Logo">
                            <span class="font-semibold tracking-widest uppercase text-lg">NSUK DIMS</span>
                        </div>

                        <div>
                            <h1 class="text-2xl/tight mb-4">Welcome to NSUK DIMS</h1>
                            <p class="text-gray-200 font-normal leading-relaxed">
                                The Departmental Information Management System (DIMS) is designed to keep staff and students
                                connected with announcements, documents, and departmental updates — anytime, anywhere.
                            </p>
                        </div>

                        <div>
                            <div class="bg-green-700 rounded-lg p-5">
                                <p class="text-gray-200 text-sm font-normal leading mb-4">
                                    Stay updated with the latest timetables, memos, and departmental news directly from your dashboard.
                                </p>
                                <div class="flex items-center gap-4">
                                    <img src="{{ url('https://nsuk.edu.ng/wp-content/uploads/2022/12/Prof.-Saadatu-Liman-DVC-Admin-NSUK.jpg') }}" alt="" class="h-12 rounded-lg">
                                    <div>
                                        <p class="font-normal">Department Admin</p>
                                        <span class="text-xs font-normal">NSUK Computer Science</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Panel (Login Form) -->
                <div class="xl:col-span-3 lg:col-span-2 lg:mx-10 my-auto">
                    <div>
                        <h1 class="text-2xl/tight mb-3">Sign In</h1>
                        <p class="text-sm font-medium leading-relaxed">
                            Access your personalized dashboard to manage announcements, staff profiles, documents, and more.
                        </p>
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4" role="alert">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5 mt-10" id="loginForm">
                        @csrf
                        <div>
                            <label class="font-medium text-sm block mb-2" for="email">Email</label>
                            <input class="text-gray-500 border-gray-300 focus:ring-0 focus:border-gray-400 text-sm rounded-lg py-2.5 px-4 w-full @error('email') border-red-500 @enderror" 
                                   type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Enter your email" 
                                    
                                   autofocus>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="font-medium text-sm" for="password">Password</label>
                                <a href="{{ route('password.request') }}" class="font-medium text-gray-500 text-sm hover:text-gray-700">Forgot your password?</a>
                            </div>
                            <input class="text-gray-500 border-gray-300 focus:ring-0 focus:border-gray-400 text-sm rounded-lg py-2.5 px-4 w-full @error('password') border-red-500 @enderror" 
                                   type="password" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password" 
                                   >
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-6 mt-8">
                            <button type="submit" 
                                    style="background: darkgreen" 
                                    class="text-white text-sm rounded-lg px-6 py-2.5 hover:bg-green-800 transition-colors duration-200 flex items-center gap-2 disabled:opacity-50"
                                    id="loginButton">
                                <span id="loginText">Sign In</span>
                                <svg id="loginSpinner" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            const button = document.getElementById('loginButton');
            const text = document.getElementById('loginText');
            const spinner = document.getElementById('loginSpinner');
            
            button.disabled = true;
            text.textContent = 'Signing In...';
            spinner.classList.remove('hidden');
        });

        // Auto-hide success messages after 5 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.bg-green-100');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 500);
            }
        }, 5000);
    </script>
@endsection