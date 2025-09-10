<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'staff_id' => 'ADMIN001',
            'phone' => '+2348012345678',
            'gender' => 'male',
            'department' => 'Computer Science',
            'faculty' => 'Science',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Staff Users
        User::create([
            'name' => 'Dr. John Doe',
            'email' => 'john@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'staff_id' => 'STAFF001',
            'phone' => '+2348012345679',
            'gender' => 'male',
            'department' => 'Computer Science',
            'faculty' => 'Science',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Prof. Jane Smith',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
            'staff_id' => 'STAFF002',
            'phone' => '+2348012345680',
            'gender' => 'female',
            'department' => 'Computer Science',
            'faculty' => 'Science',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create Student Users
        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'matric_number' => '02200470370',
            'phone' => '+2348012345681',
            'gender' => 'female',
            'date_of_birth' => '2002-05-15',
            'department' => 'Computer Science',
            'faculty' => 'Science',
            'level' => '200',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'matric_number' => '002200470371',
            'phone' => '+2348012345682',
            'gender' => 'male',
            'date_of_birth' => '2001-08-22',
            'department' => 'Computer Science',
            'faculty' => 'Science',
            'level' => '300',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Carol Brown',
            'email' => 'carol.brown@student.nsuk.edu.ng',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'matric_number' => 'NSUK/2023/CS/003',
            'phone' => '+2348012345683',
            'gender' => 'female',
            'date_of_birth' => '2003-01-10',
            'department' => 'Computer Science',
            'faculty' => 'Science',
            'level' => '100',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}