<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get staff users to assign documents to
        $staffUsers = User::where('role', 'staff')->get();
        
        if ($staffUsers->isEmpty()) {
            $this->command->warn('No staff users found. Please run UserSeeder first.');
            return;
        }

        // Create sample documents
        $sampleDocuments = [
            [
                'title' => 'Computer Science 101 - Introduction to Programming',
                'description' => 'Basic programming concepts and fundamentals for first-year students. Covers variables, data types, control structures, and basic algorithms.',
                'category' => 'lecture',
                'visibility' => 'public',
                'file_path' => 'documents/cs101_intro_programming.pdf',
                'downloads' => 45,
            ],
            [
                'title' => 'Database Systems Lecture Notes',
                'description' => 'Comprehensive notes on database design, normalization, SQL queries, and database management systems.',
                'category' => 'lecture',
                'visibility' => 'public',
                'file_path' => 'documents/database_systems_notes.pdf',
                'downloads' => 32,
            ],
            [
                'title' => 'First Semester Timetable 2024/2025',
                'description' => 'Complete timetable for all Computer Science courses in the first semester.',
                'category' => 'timetable',
                'visibility' => 'public',
                'file_path' => 'documents/first_semester_timetable_2024.pdf',
                'downloads' => 128,
            ],
            [
                'title' => 'Examination Guidelines and Procedures',
                'description' => 'Important guidelines for upcoming examinations including rules, regulations, and procedures.',
                'category' => 'memo',
                'visibility' => 'public',
                'file_path' => 'documents/exam_guidelines_2024.pdf',
                'downloads' => 89,
            ],
            [
                'title' => 'Web Development Assignment Template',
                'description' => 'Template and guidelines for web development assignments. Includes HTML, CSS, and JavaScript requirements.',
                'category' => 'other',
                'visibility' => 'public',
                'file_path' => 'documents/web_dev_assignment_template.docx',
                'downloads' => 67,
            ],
            [
                'title' => 'Staff Meeting Minutes - October 2024',
                'description' => 'Minutes from the monthly staff meeting discussing curriculum updates and administrative matters.',
                'category' => 'memo',
                'visibility' => 'private',
                'file_path' => 'documents/staff_meeting_minutes_oct2024.pdf',
                'downloads' => 12,
            ],
            [
                'title' => 'Advanced Algorithms Presentation',
                'description' => 'PowerPoint presentation covering advanced sorting algorithms, graph algorithms, and dynamic programming.',
                'category' => 'lecture',
                'visibility' => 'public',
                'file_path' => 'documents/advanced_algorithms_presentation.pptx',
                'downloads' => 23,
            ],
            [
                'title' => 'Second Semester Course Registration',
                'description' => 'Information and forms for second semester course registration process.',
                'category' => 'other',
                'visibility' => 'public',
                'file_path' => 'documents/course_registration_form.pdf',
                'downloads' => 156,
            ],
            [
                'title' => 'Software Engineering Project Guidelines',
                'description' => 'Comprehensive guidelines for final year software engineering projects including proposal format and evaluation criteria.',
                'category' => 'other',
                'visibility' => 'public',
                'file_path' => 'documents/software_eng_project_guidelines.pdf',
                'downloads' => 78,
            ],
            [
                'title' => 'Network Security Lab Manual',
                'description' => 'Laboratory manual for network security course with practical exercises and configurations.',
                'category' => 'lecture',
                'visibility' => 'public',
                'file_path' => 'documents/network_security_lab_manual.pdf',
                'downloads' => 41,
            ],
            [
                'title' => 'Department Budget Proposal 2025',
                'description' => 'Confidential budget proposal for the Computer Science department for the upcoming fiscal year.',
                'category' => 'memo',
                'visibility' => 'private',
                'file_path' => 'documents/dept_budget_proposal_2025.xlsx',
                'downloads' => 5,
            ],
            [
                'title' => 'Mobile App Development Tutorial',
                'description' => 'Step-by-step tutorial for developing mobile applications using React Native framework.',
                'category' => 'lecture',
                'visibility' => 'public',
                'file_path' => 'documents/mobile_app_dev_tutorial.pdf',
                'downloads' => 92,
            ],
            [
                'title' => 'Final Exam Timetable - December 2024',
                'description' => 'Official timetable for final examinations scheduled for December 2024.',
                'category' => 'timetable',
                'visibility' => 'public',
                'file_path' => 'documents/final_exam_timetable_dec2024.pdf',
                'downloads' => 203,
            ],
            [
                'title' => 'Research Methodology Handbook',
                'description' => 'Comprehensive handbook on research methodology for postgraduate students and faculty.',
                'category' => 'other',
                'visibility' => 'public',
                'file_path' => 'documents/research_methodology_handbook.pdf',
                'downloads' => 34,
            ],
            [
                'title' => 'Faculty Performance Review Template',
                'description' => 'Internal template for faculty performance reviews and evaluations.',
                'category' => 'memo',
                'visibility' => 'private',
                'file_path' => 'documents/faculty_performance_review.docx',
                'downloads' => 8,
            ],
        ];

        // Create documents and assign to random staff users
        foreach ($sampleDocuments as $docData) {
            $randomStaff = $staffUsers->random();
            
            Document::create([
                'user_id' => $randomStaff->id,
                'title' => $docData['title'],
                'description' => $docData['description'],
                'category' => $docData['category'],
                'visibility' => $docData['visibility'],
                'file_path' => $docData['file_path'],
                'downloads' => $docData['downloads'],
                'created_at' => now()->subDays(rand(1, 90)), // Random date within last 90 days
                'updated_at' => now()->subDays(rand(0, 30)), // Random update date
            ]);
        }

        $this->command->info('Documents seeded successfully!');
    }
}