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
        // Get staff and admin users to assign documents to
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

        // Create sample documents with department targeting
        $sampleDocuments = [
            // Computer Science Department Documents
            [
                'title' => 'Computer Science 101 - Introduction to Programming',
                'description' => 'Basic programming concepts and fundamentals for first-year students. Covers variables, data types, control structures, and basic algorithms.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/cs101_intro_programming.pdf',
                'downloads' => 145,
            ],
            [
                'title' => 'Database Systems Lecture Notes',
                'description' => 'Comprehensive notes on database design, normalization, SQL queries, and database management systems.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/database_systems_notes.pdf',
                'downloads' => 132,
            ],
            [
                'title' => 'Advanced Algorithms Presentation',
                'description' => 'PowerPoint presentation covering advanced sorting algorithms, graph algorithms, and dynamic programming.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/advanced_algorithms_presentation.pptx',
                'downloads' => 89,
            ],
            [
                'title' => 'Software Engineering Project Guidelines',
                'description' => 'Comprehensive guidelines for final year software engineering projects including proposal format and evaluation criteria.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/software_eng_project_guidelines.pdf',
                'downloads' => 178,
            ],
            [
                'title' => 'Network Security Lab Manual',
                'description' => 'Laboratory manual for network security course with practical exercises and configurations.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/network_security_lab_manual.pdf',
                'downloads' => 67,
            ],
            [
                'title' => 'Web Development Assignment Template',
                'description' => 'Template and guidelines for web development assignments. Includes HTML, CSS, and JavaScript requirements.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/web_dev_assignment_template.docx',
                'downloads' => 234,
            ],
            [
                'title' => 'Mobile App Development Tutorial',
                'description' => 'Step-by-step tutorial for developing mobile applications using React Native framework.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'computer science',
                'file_path' => 'documents/mobile_app_dev_tutorial.pdf',
                'downloads' => 156,
            ],

            // Mathematics Department Documents
            [
                'title' => 'Calculus I - Limits and Derivatives',
                'description' => 'Comprehensive notes on limits, continuity, and derivatives for first-year mathematics students.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'mathematics',
                'file_path' => 'documents/calculus_1_notes.pdf',
                'downloads' => 198,
            ],
            [
                'title' => 'Linear Algebra Problem Sets',
                'description' => 'Collection of problem sets covering vector spaces, matrices, eigenvalues, and linear transformations.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'mathematics',
                'file_path' => 'documents/linear_algebra_problems.pdf',
                'downloads' => 123,
            ],
            [
                'title' => 'Statistics and Probability Handbook',
                'description' => 'Reference handbook for statistics and probability theory with examples and applications.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'mathematics',
                'file_path' => 'documents/statistics_probability_handbook.pdf',
                'downloads' => 167,
            ],
            [
                'title' => 'Mathematical Analysis Lecture Series',
                'description' => 'Advanced mathematical analysis covering real analysis, metric spaces, and topology.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'mathematics',
                'file_path' => 'documents/mathematical_analysis_lectures.pdf',
                'downloads' => 89,
            ],

            // Physics Department Documents
            [
                'title' => 'Classical Mechanics Laboratory Manual',
                'description' => 'Laboratory experiments and procedures for classical mechanics course including pendulum, projectile motion, and rotational dynamics.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'physics',
                'file_path' => 'documents/classical_mechanics_lab.pdf',
                'downloads' => 134,
            ],
            [
                'title' => 'Quantum Physics Introduction',
                'description' => 'Introduction to quantum mechanics covering wave-particle duality, Schrödinger equation, and quantum states.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'physics',
                'file_path' => 'documents/quantum_physics_intro.pdf',
                'downloads' => 112,
            ],
            [
                'title' => 'Thermodynamics Problem Solutions',
                'description' => 'Solved problems and examples for thermodynamics course covering heat engines, entropy, and phase transitions.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'physics',
                'file_path' => 'documents/thermodynamics_solutions.pdf',
                'downloads' => 98,
            ],

            // Chemistry Department Documents
            [
                'title' => 'Organic Chemistry Lab Safety Manual',
                'description' => 'Comprehensive safety guidelines and procedures for organic chemistry laboratory work.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'chemistry',
                'file_path' => 'documents/organic_chem_safety.pdf',
                'downloads' => 187,
            ],
            [
                'title' => 'Analytical Chemistry Techniques',
                'description' => 'Guide to analytical chemistry techniques including spectroscopy, chromatography, and electrochemistry.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'chemistry',
                'file_path' => 'documents/analytical_chem_techniques.pdf',
                'downloads' => 145,
            ],
            [
                'title' => 'Chemical Bonding and Molecular Structure',
                'description' => 'Detailed notes on chemical bonding theories, molecular geometry, and intermolecular forces.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'chemistry',
                'file_path' => 'documents/chemical_bonding_notes.pdf',
                'downloads' => 156,
            ],

            // Biology Department Documents
            [
                'title' => 'Cell Biology and Genetics Manual',
                'description' => 'Laboratory manual for cell biology covering microscopy, cell division, and genetic analysis.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'biology',
                'file_path' => 'documents/cell_biology_manual.pdf',
                'downloads' => 167,
            ],
            [
                'title' => 'Ecology Field Study Guide',
                'description' => 'Field guide for ecology studies including ecosystem analysis, biodiversity assessment, and environmental monitoring.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'biology',
                'file_path' => 'documents/ecology_field_guide.pdf',
                'downloads' => 123,
            ],
            [
                'title' => 'Human Anatomy Atlas',
                'description' => 'Comprehensive anatomical reference with detailed diagrams of human body systems.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'biology',
                'file_path' => 'documents/human_anatomy_atlas.pdf',
                'downloads' => 234,
            ],

            // English Department Documents
            [
                'title' => 'Shakespeare Studies Anthology',
                'description' => 'Collection of critical essays and analysis of Shakespeare\'s major works including Hamlet, Macbeth, and Romeo and Juliet.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'english',
                'file_path' => 'documents/shakespeare_anthology.pdf',
                'downloads' => 189,
            ],
            [
                'title' => 'Creative Writing Workshop Guidelines',
                'description' => 'Guidelines and exercises for creative writing workshops covering poetry, short stories, and narrative techniques.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'english',
                'file_path' => 'documents/creative_writing_guidelines.pdf',
                'downloads' => 145,
            ],
            [
                'title' => 'Modern Literature Reading List',
                'description' => 'Comprehensive reading list for modern literature course with analysis guides and discussion questions.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'english',
                'file_path' => 'documents/modern_literature_reading_list.pdf',
                'downloads' => 167,
            ],

            // History Department Documents
            [
                'title' => 'Ancient Civilizations Study Guide',
                'description' => 'Study guide covering ancient civilizations including Egypt, Greece, Rome, and Mesopotamia.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'history',
                'file_path' => 'documents/ancient_civilizations_guide.pdf',
                'downloads' => 134,
            ],
            [
                'title' => 'World War II Historical Documents',
                'description' => 'Collection of primary source documents from World War II including speeches, letters, and official records.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => 'history',
                'file_path' => 'documents/wwii_documents.pdf',
                'downloads' => 178,
            ],

            // Economics Department Documents
            [
                'title' => 'Microeconomics Principles and Applications',
                'description' => 'Comprehensive guide to microeconomic theory covering supply and demand, market structures, and consumer behavior.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'economics',
                'file_path' => 'documents/microeconomics_principles.pdf',
                'downloads' => 156,
            ],
            [
                'title' => 'Macroeconomic Policy Analysis',
                'description' => 'Analysis of macroeconomic policies including fiscal policy, monetary policy, and international trade.',
                'category' => 'lecture',
                'visibility' => 'public',
                'target_department' => 'economics',
                'file_path' => 'documents/macroeconomic_policy.pdf',
                'downloads' => 123,
            ],

            // General Documents (No Department Targeting)
            [
                'title' => 'University Academic Calendar 2024/2025',
                'description' => 'Complete academic calendar showing important dates, holidays, and examination periods for all departments.',
                'category' => 'timetable',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/academic_calendar_2024_2025.pdf',
                'downloads' => 456,
            ],
            [
                'title' => 'First Semester Timetable 2024/2025',
                'description' => 'Complete timetable for all courses across all departments in the first semester.',
                'category' => 'timetable',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/first_semester_timetable_2024.pdf',
                'downloads' => 389,
            ],
            [
                'title' => 'Final Exam Timetable - December 2024',
                'description' => 'Official timetable for final examinations scheduled for December 2024 across all departments.',
                'category' => 'timetable',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/final_exam_timetable_dec2024.pdf',
                'downloads' => 567,
            ],
            [
                'title' => 'Examination Guidelines and Procedures',
                'description' => 'Important guidelines for upcoming examinations including rules, regulations, and procedures for all students.',
                'category' => 'memo',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/exam_guidelines_2024.pdf',
                'downloads' => 234,
            ],
            [
                'title' => 'Student Handbook 2024/2025',
                'description' => 'Comprehensive student handbook covering university policies, procedures, and student services.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/student_handbook_2024.pdf',
                'downloads' => 345,
            ],
            [
                'title' => 'Course Registration Guidelines',
                'description' => 'Step-by-step guide for course registration process applicable to all departments and levels.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/course_registration_guidelines.pdf',
                'downloads' => 278,
            ],
            [
                'title' => 'Library Services and Resources',
                'description' => 'Guide to library services, resources, and research facilities available to all students and faculty.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/library_services_guide.pdf',
                'downloads' => 189,
            ],
            [
                'title' => 'Research Methodology Handbook',
                'description' => 'Comprehensive handbook on research methodology for undergraduate and postgraduate students across all disciplines.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/research_methodology_handbook.pdf',
                'downloads' => 167,
            ],
            [
                'title' => 'Graduate School Application Guide',
                'description' => 'Complete guide for students applying to graduate programs including application procedures and requirements.',
                'category' => 'other',
                'visibility' => 'public',
                'target_department' => null, // General document
                'file_path' => 'documents/graduate_school_guide.pdf',
                'downloads' => 145,
            ],

            // Private/Staff Documents
            [
                'title' => 'Staff Meeting Minutes - November 2024',
                'description' => 'Minutes from the monthly staff meeting discussing curriculum updates and administrative matters.',
                'category' => 'memo',
                'visibility' => 'private',
                'target_department' => null,
                'file_path' => 'documents/staff_meeting_minutes_nov2024.pdf',
                'downloads' => 23,
            ],
            [
                'title' => 'Faculty Performance Review Template',
                'description' => 'Internal template for faculty performance reviews and evaluations.',
                'category' => 'memo',
                'visibility' => 'private',
                'target_department' => null,
                'file_path' => 'documents/faculty_performance_review.docx',
                'downloads' => 15,
            ],
            [
                'title' => 'Department Budget Proposal 2025',
                'description' => 'Confidential budget proposal for various departments for the upcoming fiscal year.',
                'category' => 'memo',
                'visibility' => 'private',
                'target_department' => null,
                'file_path' => 'documents/dept_budget_proposal_2025.xlsx',
                'downloads' => 8,
            ],
            [
                'title' => 'Curriculum Review Committee Report',
                'description' => 'Internal report from the curriculum review committee with recommendations for course updates.',
                'category' => 'memo',
                'visibility' => 'private',
                'target_department' => null,
                'file_path' => 'documents/curriculum_review_report.pdf',
                'downloads' => 12,
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
                'target_department' => $docData['target_department'],
                'file_path' => $docData['file_path'],
                'downloads' => $docData['downloads'],
                'created_at' => now()->subDays(rand(1, 90)), // Random date within last 90 days
                'updated_at' => now()->subDays(rand(0, 30)), // Random update date
            ]);
        }

        $this->command->info('Documents seeded successfully with department targeting!');
        $this->command->info('Created ' . count($sampleDocuments) . ' documents');
        
        // Show statistics
        $generalCount = collect($sampleDocuments)->where('target_department', null)->count();
        $departmentSpecificCount = collect($sampleDocuments)->whereNotNull('target_department')->count();
        $publicCount = collect($sampleDocuments)->where('visibility', 'public')->count();
        $privateCount = collect($sampleDocuments)->where('visibility', 'private')->count();
        
        $this->command->info("- General documents (all departments): {$generalCount}");
        $this->command->info("- Department-specific documents: {$departmentSpecificCount}");
        $this->command->info("- Public documents: {$publicCount}");
        $this->command->info("- Private documents: {$privateCount}");
        
        // Show department breakdown
        $departmentBreakdown = collect($sampleDocuments)
            ->whereNotNull('target_department')
            ->groupBy('target_department')
            ->map->count();
            
        foreach ($departmentBreakdown as $dept => $count) {
            $this->command->info("  - " . ucfirst($dept) . ": {$count} documents");
        }

        // Show category breakdown
        $categoryBreakdown = collect($sampleDocuments)
            ->groupBy('category')
            ->map->count();
            
        $this->command->info("\nCategory breakdown:");
        foreach ($categoryBreakdown as $category => $count) {
            $this->command->info("  - " . ucfirst($category) . ": {$count} documents");
        }
    }
}