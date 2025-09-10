<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function showDashboard()
    {
        $viewData = [
           'meta_title'=> 'Student Dashboard | Nsuk Document Management System',
           'meta_desc'=> 'Departmental Information Management System with document management and announcements',
           'meta_image'=> url('logo.png'),
        ];

        return view('student.home', $viewData);
    }
}