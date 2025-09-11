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
        $staffUsers = User::where('role', 'staff')->get();
        
        if ($staffUsers->isEmpty()) {
            $this->command->warn('No staff users found. Please run UserSeeder first.');
            return;
        }

        // Sample announcements
        $sampleAnnouncements = [
            [
                'title' => 'Welcome to New Academic Session 2024/2025',
                'body' => 'We are pleased to welcome all students and staff to the new academic session. Classes will commence on Monday, September 16th, 2024. All students are expected to complete their registration before the commencement of lectures.',
                'category' => 'general',
                'visibility' => 'public',
                'expiry_date' => now()->addMonths(2)->toDateString(),
                'views' => 245,
            ],
            [
                'title' => 'First Semester Examination Timetable Released',
                'body' => 'The first semester examination timetable for 2024/2025 academic session has been released. Students are advised to check the notice board and department website for their examination schedule. All examinations will commence on December 2nd, 2024.',
                'category' => 'exam',
                'visibility' => 'public',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 189,
            ],
            [
                'title' => 'Staff Meeting - Curriculum Review',
                'body' => 'All academic staff are invited to attend the curriculum review meeting scheduled for Friday, November 15th, 2024, at 10:00 AM in the conference room. We will be discussing updates to course content and assessment methods.',
                'category' => 'memo',
                'visibility' => 'staff',
                'expiry_date' => now()->addWeeks(2)->toDateString(),
                'views' => 34,
            ],
            [
                'title' => 'Library Operating Hours Extended',
                'body' => 'Due to the approaching examination period, the library operating hours have been extended. The library will now be open from 7:00 AM to 11:00 PM, Monday through Sunday, effective immediately until the end of examinations.',
                'category' => 'general',
                'visibility' => 'public',
                'expiry_date' => now()->addMonths(3)->toDateString(),
                'views' => 156,
            ],
            [
                'title' => 'Computer Science Department Seminar Series',
                'body' => 'The Computer Science Department is pleased to announce the commencement of our monthly seminar series. The first seminar titled "Artificial Intelligence in Modern Computing" will be held on November 20th, 2024, at 2:00 PM in Lecture Hall A.',
                'category' => 'academic',
                'visibility' => 'public',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 78,
            ],
            [
                'title' => 'Course Registration Deadline Extended',
                'body' => 'The deadline for course registration has been extended to November 30th, 2024. Students who have not completed their registration are advised to do so before the new deadline to avoid late registration penalties.',
                'category' => 'academic',
                'visibility' => 'student',
                'expiry_date' => now()->addWeeks(3)->toDateString(),
                'views' => 203,
            ],
            [
                'title' => 'New Laboratory Equipment Installation',
                'body' => 'We are excited to announce the installation of new laboratory equipment in the Computer Science lab. The new equipment includes high-performance workstations and networking devices that will enhance practical learning experiences.',
                'category' => 'general',
                'visibility' => 'public',
                'expiry_date' => null, // No expiry
                'views' => 92,
            ],
            [
                'title' => 'Revised Lecture Timetable - Week 8',
                'body' => 'Please note that there have been some changes to the lecture timetable for week 8 due to a faculty meeting. CS 301 (Database Systems) has been moved from Tuesday 10 AM to Wednesday 2 PM. CS 401 (Software Engineering) remains unchanged.',
                'category' => 'timetable',
                'visibility' => 'public',
                'expiry_date' => now()->addWeek()->toDateString(),
                'views' => 167,
            ],
            [
                'title' => 'Research Grant Application Deadline',
                'body' => 'Faculty members interested in applying for research grants are reminded that the application deadline is December 15th, 2024. Application forms and guidelines are available at the research office.',
                'category' => 'memo',
                'visibility' => 'staff',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 23,
            ],
            [
                'title' => 'Student Project Presentation Schedule',
                'body' => 'Final year students are required to present their projects during the week of December 9-13, 2024. The presentation schedule will be posted on the department notice board by November 25th, 2024.',
                'category' => 'academic',
                'visibility' => 'public',
                'expiry_date' => now()->addMonth()->toDateString(),
                'views' => 134,
            ],
            [
                'title' => 'Network Maintenance - Weekend Downtime',
                'body' => 'The university network will undergo scheduled maintenance this weekend (November 16-17, 2024) from 12:00 AM to 6:00 AM. Internet services may be intermittent during this period.',
                'category' => 'other',
                'visibility' => 'public',
                'expiry_date' => now()->addDays(3)->toDateString(),
                'views' => 89,
            ],
            [
                'title' => 'Graduation Ceremony Announcement',
                'body' => 'The graduation ceremony for the 2023/2024 academic session will be held on January 15th, 2025. All graduating students and their families are invited to attend this momentous occasion.',
                'category' => 'general',
                'visibility' => 'public',
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
                'expiry_date' => $announcementData['expiry_date'],
                'views' => $announcementData['views'],
                'is_active' => true,
                'created_at' => now()->subDays(rand(1, 60)), // Random date within last 60 days
                'updated_at' => now()->subDays(rand(0, 30)), // Random update date
            ]);
        }

        $this->command->info('Announcements seeded successfully!');
    }
}