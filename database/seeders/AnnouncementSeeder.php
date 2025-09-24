<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get staff users to assign announcements to
        $staffUsers = User::whereIn('role', ['admin', 'staff'])->get();
        
        if ($staffUsers->isEmpty()) {
            $this->command->warn('No staff users found. Please run UserSeeder first.');
            return;
        }

        // Available departments
        $departments = [
            'computer science',
            'mathematics',
            'physics',
            'chemistry',
            'biology',
            'english',
            'history',
            'economics',
        ];

        // Sample announcements with department targeting
        $sampleAnnouncements = [
            [
                'title' => 'Welcome to New Academic Session 2024/2025',
                'body' => 'We are pleased to welcome all students and staff to the new academic session. Classes will commence on Monday, September 16th, 2024. All students are expected to complete their registration before the commencement of lectures.',
                'category' => 'general',
                'visibility' => 'public',
                'target_department' => null, // General announcement for all departments
                'expiry_date' => now()->addMonths(2)->toDateString(),
                'views' => 245,
            ],
            [
                'title' => 'Computer Science Department - Programming Contest',
                'body' => 'The Computer Science Department is organizing an inter-class programming contest. Students from all levels are encouraged to participate. Registration deadline is November 25th, 2024. Prizes will be awarded to top performers.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'computer science',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 89,
            ],
            [
                'title' => 'Mathematics Department - Calculus Workshop',
                'body' => 'The Mathematics Department will be conducting a special calculus workshop for 200-level students. The workshop will cover advanced integration techniques and will be held every Friday for the next 4 weeks.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'mathematics',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 67,
            ],
            [
                'title' => 'Physics Lab - New Equipment Installation',
                'body' => 'New laboratory equipment has been installed in the Physics Department. Students taking PHY 301 (Quantum Physics Lab) should report to the lab coordinator for orientation on the new equipment usage.',
                'category' => 'general',
                'visibility' => 'student',
                'target_department' => 'physics',
                'expiry_date' => now()->addWeeks(3)->toDateString(),
                'views' => 45,
            ],
            [
                'title' => 'First Semester Examination Timetable Released',
                'body' => 'The first semester examination timetable for 2024/2025 academic session has been released. Students are advised to check the notice board and department website for their examination schedule. All examinations will commence on December 2nd, 2024.',
                'category' => 'exam',
                'visibility' => 'public',
                'target_department' => null, // General for all departments
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 189,
            ],
            [
                'title' => 'Chemistry Department - Lab Safety Training',
                'body' => 'All Chemistry students are required to attend the mandatory lab safety training session. The training will be conducted on November 18th, 2024, at 10:00 AM in Chemistry Lab 1. Attendance is compulsory for all practical courses.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'chemistry',
                'expiry_date' => now()->addWeeks(2)->toDateString(),
                'views' => 78,
            ],
            [
                'title' => 'Biology Department - Field Trip to National Park',
                'body' => 'The Biology Department is organizing an educational field trip to the National Park for BIO 401 students. The trip is scheduled for November 30th, 2024. Students interested in participating should register with the department secretary.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'biology',
                'expiry_date' => now()->addWeeks(3)->toDateString(),
                'views' => 56,
            ],
            [
                'title' => 'English Department - Literary Festival 2024',
                'body' => 'The English Department presents the Annual Literary Festival 2024. Join us for poetry readings, drama performances, and literary discussions. The festival will run from December 5-7, 2024, in the Arts Theatre.',
                'category' => 'academic',
                'visibility' => 'public',
                'target_department' => 'english',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 92,
            ],
            [
                'title' => 'Staff Meeting - Curriculum Review',
                'body' => 'All academic staff are invited to attend the curriculum review meeting scheduled for Friday, November 15th, 2024, at 10:00 AM in the conference room. We will be discussing updates to course content and assessment methods.',
                'category' => 'memo',
                'visibility' => 'staff',
                'target_department' => null, // General for all staff
                'expiry_date' => now()->addWeeks(2)->toDateString(),
                'views' => 34,
            ],
            [
                'title' => 'History Department - Guest Lecture Series',
                'body' => 'The History Department is pleased to announce a guest lecture series on "Ancient Civilizations and Modern Society". The first lecture will be delivered by Prof. Sarah Johnson on November 22nd, 2024, at 2:00 PM.',
                'category' => 'academic',
                'visibility' => 'public',
                'target_department' => 'history',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 43,
            ],
            [
                'title' => 'Economics Department - Research Seminar',
                'body' => 'The Economics Department invites all students and faculty to attend a research seminar on "Microeconomic Theory and Market Dynamics". The seminar will be held on November 28th, 2024, at 11:00 AM in Lecture Hall B.',
                'category' => 'academic',
                'visibility' => 'public',
                'target_department' => 'economics',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 38,
            ],
            [
                'title' => 'Library Operating Hours Extended',
                'body' => 'Due to the approaching examination period, the library operating hours have been extended. The library will now be open from 7:00 AM to 11:00 PM, Monday through Sunday, effective immediately until the end of examinations.',
                'category' => 'general',
                'visibility' => 'public',
                'target_department' => null, // General for all departments
                'expiry_date' => now()->addMonths(3)->toDateString(),
                'views' => 156,
            ],
            [
                'title' => 'Computer Science - Final Year Project Guidelines',
                'body' => 'Final year Computer Science students are reminded to submit their project proposals by November 20th, 2024. The project guidelines and submission forms are available on the department website. Late submissions will not be accepted.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'computer science',
                'expiry_date' => now()->addWeeks(2)->toDateString(),
                'views' => 124,
            ],
            [
                'title' => 'Mathematics Department - Scholarship Opportunity',
                'body' => 'The Mathematics Department announces a scholarship opportunity for outstanding students. Applications are now open for the Academic Excellence Scholarship 2024. Eligible students should submit their applications by December 1st, 2024.',
                'category' => 'general',
                'visibility' => 'student',
                'target_department' => 'mathematics',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 87,
            ],
            [
                'title' => 'Course Registration Deadline Extended',
                'body' => 'The deadline for course registration has been extended to November 30th, 2024. Students who have not completed their registration are advised to do so before the new deadline to avoid late registration penalties.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => null, // General for all departments
                'expiry_date' => now()->addWeeks(3)->toDateString(),
                'views' => 203,
            ],
            [
                'title' => 'Physics Department - Research Collaboration',
                'body' => 'The Physics Department has entered into a research collaboration with the National Institute of Technology. This partnership will provide students with opportunities for advanced research projects and internships.',
                'category' => 'general',
                'visibility' => 'public',
                'target_department' => 'physics',
                'expiry_date' => null, // No expiry
                'views' => 65,
            ],
            [
                'title' => 'Chemistry Department - Industrial Visit',
                'body' => 'Chemistry students (300 and 400 level) are invited to participate in an industrial visit to the Petrochemical Plant. The visit is scheduled for December 3rd, 2024. Transportation will be provided by the department.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'chemistry',
                'expiry_date' => now()->addWeeks(4)->toDateString(),
                'views' => 72,
            ],
            [
                'title' => 'Revised Lecture Timetable - Week 8',
                'body' => 'Please note that there have been some changes to the lecture timetable for week 8 due to a faculty meeting. CS 301 (Database Systems) has been moved from Tuesday 10 AM to Wednesday 2 PM. CS 401 (Software Engineering) remains unchanged.',
                'category' => 'timetable',
                'visibility' => 'student',
                'target_department' => 'computer science',
                'expiry_date' => now()->addWeek()->toDateString(),
                'views' => 167,
            ],
            [
                'title' => 'Biology Department - Microscopy Workshop',
                'body' => 'The Biology Department will conduct a hands-on microscopy workshop for 200-level students. The workshop will cover advanced microscopy techniques and specimen preparation. Registration is required.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'biology',
                'expiry_date' => now()->addWeeks(2)->toDateString(),
                'views' => 54,
            ],
            [
                'title' => 'Network Maintenance - Weekend Downtime',
                'body' => 'The university network will undergo scheduled maintenance this weekend (November 16-17, 2024) from 12:00 AM to 6:00 AM. Internet services may be intermittent during this period.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => null, // General for all departments
                'expiry_date' => now()->addDays(3)->toDateString(),
                'views' => 89,
            ],
            [
                'title' => 'English Department - Writing Competition',
                'body' => 'The English Department announces the Annual Creative Writing Competition. Students can submit short stories, poems, or essays. Submission deadline is December 10th, 2024. Prizes will be awarded in each category.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'english',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 76,
            ],
            [
                'title' => 'History Department - Museum Visit',
                'body' => 'History students are invited to join the department visit to the National Museum. The visit will provide insights into historical artifacts and cultural heritage. Date: November 25th, 2024.',
                'category' => 'academic',
                'visibility' => 'student',
                'target_department' => 'history',
                'expiry_date' => now()->addWeeks(3)->toDateString(),
                'views' => 41,
            ],
            [
                'title' => 'Economics Department - Career Fair',
                'body' => 'The Economics Department is organizing a career fair featuring representatives from banks, consulting firms, and government agencies. The fair will be held on December 8th, 2024, in the main auditorium.',
                'category' => 'general',
                'visibility' => 'student',
                'target_department' => 'economics',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 95,
            ],
            [
                'title' => 'Graduation Ceremony Announcement',
                'body' => 'The graduation ceremony for the 2023/2024 academic session will be held on January 15th, 2025. All graduating students and their families are invited to attend this momentous occasion.',
                'category' => 'general',
                'visibility' => 'public',
                'target_department' => null, // General for all departments
                'expiry_date' => now()->addMonths(4)->toDateString(),
                'views' => 312,
            ],
        ];

        // Create announcements and assign to random staff users
        foreach ($sampleAnnouncements as $announcementData) {
            $randomStaff = $staffUsers->random();
            
            Announcement::create([
                'user_id' => $randomStaff->id,
                'title' => $announcementData['title'],
                'body' => $announcementData['body'],
                'category' => $announcementData['category'],
                'visibility' => $announcementData['visibility'],
                'target_department' => $announcementData['target_department'],
                'expiry_date' => $announcementData['expiry_date'],
                'views' => $announcementData['views'],
                'is_active' => true,
                'created_at' => now()->subDays(rand(1, 60)), // Random date within last 60 days
                'updated_at' => now()->subDays(rand(0, 30)), // Random update date
            ]);
        }

        $this->command->info('Announcements seeded successfully with department targeting!');
        $this->command->info('Created ' . count($sampleAnnouncements) . ' announcements');
        
        // Show statistics
        $generalCount = collect($sampleAnnouncements)->where('target_department', null)->count();
        $departmentSpecificCount = collect($sampleAnnouncements)->whereNotNull('target_department')->count();
        
        $this->command->info("- General announcements (all departments): {$generalCount}");
        $this->command->info("- Department-specific announcements: {$departmentSpecificCount}");
        
        // Show department breakdown
        $departmentBreakdown = collect($sampleAnnouncements)
            ->whereNotNull('target_department')
            ->groupBy('target_department')
            ->map->count();
            
        foreach ($departmentBreakdown as $dept => $count) {
            $this->command->info("  - " . ucfirst($dept) . ": {$count} announcements");
        }
    }
}