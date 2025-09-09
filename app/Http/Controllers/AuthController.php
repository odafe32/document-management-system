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

}