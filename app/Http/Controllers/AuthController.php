<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        $viewData = [
           'meta_title'=> 'Login | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('auth.login', $viewData);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Check if user exists and is active
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        if ($user->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => ['Your account is not active. Please contact administrator.'],
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Update last login time
            $user->update(['last_login_at' => now()]);

            // Redirect based on user role
            return redirect()->intended($user->getDashboardRoute());
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    public function showForgotPassword()
    {
        $viewData = [
           'meta_title'=> 'Forgot password | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('auth.forgot', $viewData);
    }
}