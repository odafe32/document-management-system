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

                    <form method="POST" action="" class="space-y-5 mt-10">
                        @csrf
                        <div>
                            <label class="font-medium text-sm block mb-2" for="email">Email</label>
                            <input class="text-gray-500 border-gray-300 focus:ring-0 focus:border-gray-400 text-sm rounded-lg py-2.5 px-4 w-full" 
                                   type="email" id="email" name="email" placeholder="Enter your email" required autofocus>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="font-medium text-sm" for="password">Password</label>
                                <a href="{{ route('password.request') }}" class="font-medium text-gray-500 text-sm">Forgot your password?</a>
                            </div>
                            <input class="text-gray-500 border-gray-300 focus:ring-0 focus:border-gray-400 text-sm rounded-lg py-2.5 px-4 w-full" 
                                   type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <div class="flex flex-wrap items-center justify-between gap-6 mt-8">
                            <button type="submit" style="background: darkgreen" 
                                    class="text-white text-sm rounded-lg px-6 py-2.5">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
/