<?php

namespace Database\Seeders;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get students and staff users
        $students = User::where('role', 'student')->get();
        $staff = User::where('role', 'staff')->get();
        
        if ($students->isEmpty()) {
            $this->command->warn('No student users found. Please run UserSeeder first.');
            return;
        }

        if ($staff->isEmpty()) {
            $this->command->warn('No staff users found. Please run UserSeeder first.');
            return;
        }

        // Sample feedbacks
        $sampleFeedbacks = [
            [
                'subject' => 'Issue with Course Registration System',
                'message' => 'I am having trouble accessing the course registration portal. Every time I try to log in, it shows an error message saying "Invalid credentials" even though I am using the correct login details. This is preventing me from registering for my courses for the upcoming semester. Please help resolve this issue urgently.',
                'status' => 'pending',
                'priority' => 3,
                'is_read' => false,
            ],
            [
                'subject' => 'Request for Transcript',
                'message' => 'I would like to request an official transcript for my graduate school application. I need it to be sent directly to the admissions office. Please let me know the procedure and any fees involved. My student ID is CS/2021/001.',
                'status' => 'in_review',
                'priority' => 2,
                'is_read' => true,
                'reply' => 'Thank you for your request. Please visit the academic office with your ID and fill out the transcript request form. The fee is ₦5,000 and processing takes 5-7 working days.',
                'replied_at' => now()->subDays(2),
            ],
            [
                'subject' => 'Laboratory Equipment Not Working',
                'message' => 'The computers in Lab 3 are not functioning properly. Most of them won\'t boot up, and the ones that do are extremely slow. This is affecting our practical sessions and project work. Can this be looked into as soon as possible?',
                'status' => 'resolved',
                'priority' => 2,
                'is_read' => true,
                'reply' => 'Thank you for reporting this issue. The IT department has been notified and they have fixed the computers in Lab 3. All systems are now working properly. Please report any further issues.',
                'replied_at' => now()->subDays(5),
            ],
            [
                'subject' => 'Clarification on Assignment Deadline',
                'message' => 'I need clarification on the deadline for the Database Systems assignment. The course outline says November 30th, but the lecturer mentioned December 5th in class. Which date should I follow?',
                'status' => 'resolved',
                'priority' => 1,
                'is_read' => true,
                'reply' => 'The correct deadline is December 5th as announced in class. The course outline will be updated to reflect this change. Thank you for bringing this to our attention.',
                'replied_at' => now()->subDays(1),
            ],
            [
                'subject' => 'Missing Grade for Mid-term Exam',
                'message' => 'I took the mid-term exam for Software Engineering (CS 301) three weeks ago, but my grade is still not showing in the student portal. Other students have received their grades. Please check and update my grade.',
                'status' => 'pending',
                'priority' => 2,
                'is_read' => false,
            ],
            [
                'subject' => 'Request for Letter of Recommendation',
                'message' => 'I am applying for an internship at a tech company and need a letter of recommendation from the department. I have maintained a CGPA of 4.2 and have been actively involved in departmental activities. Could you please help me with this?',
                'status' => 'in_review',
                'priority' => 1,
                'is_read' => true,
            ],
            [
                'subject' => 'Internet Connectivity Issues in Hostel',
                'message' => 'The internet connection in the student hostel has been very poor for the past week. It keeps disconnecting and the speed is very slow. This is affecting our online classes and research work. Please look into this matter.',
                'status' => 'pending',
                'priority' => 2,
                'is_read' => false,
            ],
            [
                'subject' => 'Suggestion for New Programming Course',
                'message' => 'I would like to suggest adding a course on Mobile App Development to our curriculum. Many students are interested in learning Android and iOS development, and it would be very beneficial for our career prospects. Other universities have similar courses.',
                'status' => 'in_review',
                'priority' => 1,
                'is_read' => true,
                'reply' => 'Thank you for your suggestion. The curriculum committee will review this proposal in the next meeting. We appreciate student input on course offerings.',
                'replied_at' => now()->subDays(3),
            ],
            [
                'subject' => 'Library Book Renewal Issue',
                'message' => 'I am unable to renew my library books online. The system shows an error message. I need to keep these books for my final year project research. Please help me resolve this issue or renew the books manually.',
                'status' => 'resolved',
                'priority' => 1,
                'is_read' => true,
                'reply' => 'The library system has been updated and you should now be able to renew your books online. Your current books have been renewed for an additional 2 weeks.',
                'replied_at' => now()->subHours(6),
            ],
            [
                'subject' => 'Complaint About Lecturer Behavior',
                'message' => 'I want to report inappropriate behavior by one of the lecturers. They have been consistently late to classes, often cancel classes without notice, and are not responsive to student questions. This is affecting our learning experience.',
                'status' => 'pending',
                'priority' => 3,
                'is_read' => false,
            ],
            [
                'subject' => 'Request for Make-up Exam',
                'message' => 'I missed the Computer Networks exam due to a medical emergency (hospital admission). I have the medical certificate as proof. Please allow me to take a make-up exam. I can provide all necessary documentation.',
                'status' => 'in_review',
                'priority' => 3,
                'is_read' => true,
            ],
            [
                'subject' => 'Scholarship Application Inquiry',
                'message' => 'I would like to inquire about available scholarships for undergraduate students. I have maintained excellent grades and come from a low-income family. Please provide information about scholarship opportunities and application procedures.',
                'status' => 'resolved',
                'priority' => 2,
                'is_read' => true,
                'reply' => 'Please visit the student affairs office for scholarship information. Applications for the merit-based scholarship open in January. Bring your academic transcripts and financial documents.',
                'replied_at' => now()->subDays(4),
            ],
        ];

        // Create feedbacks and assign to random students and staff
        foreach ($sampleFeedbacks as $feedbackData) {
            $randomStudent = $students->random();
            $randomStaff = $staff->random();
            
            $feedback = Feedback::create([
                'user_id' => $randomStudent->id,
                'staff_id' => in_array($feedbackData['status'], ['in_review', 'resolved']) ? $randomStaff->id : null,
                'subject' => $feedbackData['subject'],
                'message' => $feedbackData['message'],
                'status' => $feedbackData['status'],
                'priority' => $feedbackData['priority'],
                'is_read' => $feedbackData['is_read'],
                'reply' => $feedbackData['reply'] ?? null,
                'replied_at' => $feedbackData['replied_at'] ?? null,
                'created_at' => now()->subDays(rand(1, 30)), // Random date within last 30 days
                'updated_at' => now()->subDays(rand(0, 15)), // Random update date
            ]);
        }

        $this->command->info('Feedbacks seeded successfully!');
    }
}