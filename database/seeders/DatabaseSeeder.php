<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CvDocument;
use App\Models\HelpMessage;
use App\Models\Portfolio;
use App\Models\PortfolioAssessment;
use App\Models\Skill;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════════
        // 1. CATEGORIES (master data)
        // ═══════════════════════════════════════
        $categoryNames = [
            'Desain', 'Teknik', 'Penulisan', 'Arsitektur', 'Fotografi', 'Bisnis',
            'Prototipe', 'Konstruksi', 'Otomotif', 'Jaringan', 'Animasi', 'Perfilman', 'Elektronika'
        ];
        $categories = collect($categoryNames)->map(fn ($name) => Category::create(['name' => $name]));

        // ═══════════════════════════════════════
        // 2. ADMIN USER
        // ═══════════════════════════════════════
        $admin = User::create([
            'name'      => 'Admin Scholarchive',
            'email'     => 'admin@scholarchive.id',
            'password'  => 'password',
            'role'      => 'admin',
            'is_active' => true,
        ]); 

        // ═══════════════════════════════════════
        // 3. STUDENT USERS + PROFILES + SKILLS
        // ═══════════════════════════════════════
        $studentsData = [
            [
                'name'  => 'Sarah Jenkins',
                'email' => 's.jenkins@school.edu',
                'profile' => ['class_name' => 'XII RPL 1', 'major' => 'Interaction Design', 'bio' => 'Passionate about creating meaningful digital experiences. I love exploring the intersection of design and technology.', 'phone' => '+62 812-3456-7890', 'address' => 'Bandung, Indonesia'],
                'skills' => [
                    ['name' => 'UI/UX Design', 'level' => 'Advanced'],
                    ['name' => 'Figma', 'level' => 'Advanced'],
                    ['name' => 'Adobe Illustrator', 'level' => 'Intermediate'],
                    ['name' => 'Prototyping', 'level' => 'Advanced'],
                    ['name' => 'User Research', 'level' => 'Intermediate'],
                    ['name' => 'HTML/CSS', 'level' => 'Intermediate'],
                    ['name' => 'Branding', 'level' => 'Beginner'],
                ],
            ],
            [
                'name'  => 'Alice Chen',
                'email' => 'a.chen@school.edu',
                'profile' => ['class_name' => 'XII RPL 2', 'major' => 'Software Engineering', 'bio' => 'Full-stack developer with a love for clean code and scalable architecture.', 'phone' => '+62 813-2222-3333', 'address' => 'Jakarta, Indonesia'],
                'skills' => [
                    ['name' => 'React', 'level' => 'Advanced'],
                    ['name' => 'Node.js', 'level' => 'Advanced'],
                    ['name' => 'TypeScript', 'level' => 'Intermediate'],
                    ['name' => 'MySQL', 'level' => 'Intermediate'],
                    ['name' => 'Docker', 'level' => 'Beginner'],
                ],
            ],
            [
                'name'  => 'Marcus Johnson',
                'email' => 'm.johnson@school.edu',
                'profile' => ['class_name' => 'XII RPL 1', 'major' => 'Backend Development', 'bio' => 'Aspiring backend engineer focused on building robust APIs and microservices.', 'phone' => '+62 814-4444-5555', 'address' => 'Surabaya, Indonesia'],
                'skills' => [
                    ['name' => 'Laravel', 'level' => 'Advanced'],
                    ['name' => 'PHP', 'level' => 'Advanced'],
                    ['name' => 'REST API', 'level' => 'Advanced'],
                    ['name' => 'PostgreSQL', 'level' => 'Intermediate'],
                    ['name' => 'Redis', 'level' => 'Beginner'],
                ],
            ],
            [
                'name'  => 'Elena Rodriguez',
                'email' => 'e.rodriguez@school.edu',
                'profile' => ['class_name' => 'XI DKV 1', 'major' => 'Architecture', 'bio' => 'Creative thinker who loves turning abstract concepts into tangible structures.', 'phone' => '+62 815-6666-7777', 'address' => 'Yogyakarta, Indonesia'],
                'skills' => [
                    ['name' => 'AutoCAD', 'level' => 'Advanced'],
                    ['name' => 'SketchUp', 'level' => 'Intermediate'],
                    ['name' => '3D Rendering', 'level' => 'Intermediate'],
                    ['name' => 'Interior Design', 'level' => 'Beginner'],
                ],
            ],
            [
                'name'  => 'Emily Rodriguez',
                'email' => 'emily.r@school.edu',
                'profile' => ['class_name' => 'XII RPL 2', 'major' => 'Creative Writing', 'bio' => 'Writer and storyteller passionate about literature, journalism, and content creation.', 'phone' => '+62 816-8888-9999', 'address' => 'Semarang, Indonesia'],
                'skills' => [
                    ['name' => 'Creative Writing', 'level' => 'Advanced'],
                    ['name' => 'Content Strategy', 'level' => 'Intermediate'],
                    ['name' => 'Copywriting', 'level' => 'Advanced'],
                    ['name' => 'Research', 'level' => 'Intermediate'],
                    ['name' => 'SEO Writing', 'level' => 'Beginner'],
                ],
            ],
        ];

        $students = [];
        foreach ($studentsData as $data) {
            $user = User::create([
                'name'      => $data['name'],
                'email'     => $data['email'],
                'password'  => 'password',
                'role'      => 'student',
                'is_active' => true,
            ]);

            StudentProfile::create(array_merge(
                ['user_id' => $user->id],
                $data['profile']
            ));

            foreach ($data['skills'] as $skill) {
                Skill::create(array_merge(['student_id' => $user->id], $skill));
            }

            $students[] = $user;
        }

        // ═══════════════════════════════════════
        // 4. PORTFOLIOS
        // ═══════════════════════════════════════
        $portfoliosData = [
            // Sarah Jenkins
            [
                'student_idx' => 0,
                'title'       => 'Nova Brand Identity',
                'type'        => 'desain',
                'description' => 'Comprehensive branding project including logo design, color palette selection, typography, and brand guidelines for a fictional tech startup. The project covers visual identity from concept to final deliverables.',
                'is_featured' => true,
                'view_count'  => 245,
                'categories'  => ['Desain'],
                'score'       => 92,
                'feedback'    => 'Excellent branding work. The color palette is cohesive and the guidelines are comprehensive. Very professional output.',
            ],
            [
                'student_idx' => 0,
                'title'       => 'Mobile Banking App Redesign',
                'type'        => 'desain',
                'description' => 'Complete UI/UX redesign of a mobile banking application focusing on improved usability, accessibility, and modern visual design. Includes user research, wireframes, and high-fidelity mockups.',
                'is_featured' => false,
                'view_count'  => 178,
                'categories'  => ['Desain'],
                'score'       => 88,
                'feedback'    => 'Solid redesign with good user research backing. Navigation flow could be improved slightly.',
            ],
            [
                'student_idx' => 0,
                'title'       => 'Event Branding Kit',
                'type'        => 'desain',
                'description' => 'A complete branding kit for a fictional tech conference, including event logo, social media templates, merchandise mockups, and presentation deck.',
                'is_featured' => false,
                'view_count'  => 67,
                'categories'  => ['Desain', 'Bisnis'],
                'score'       => null,
                'feedback'    => null,
            ],
            // Alice Chen
            [
                'student_idx' => 1,
                'title'       => 'UX Case Study: Sustainable Transport',
                'type'        => 'dokumen',
                'description' => 'In-depth UX case study exploring sustainable transportation solutions for urban areas. Includes competitive analysis, user personas, journey maps, and design recommendations.',
                'is_featured' => true,
                'view_count'  => 312,
                'categories'  => ['Desain', 'Penulisan'],
                'score'       => 92,
                'feedback'    => 'Outstanding research methodology and clear presentation of findings. Well-structured case study.',
            ],
            [
                'student_idx' => 1,
                'title'       => 'React Dashboard Component Library',
                'type'        => 'desain',
                'description' => 'A reusable React component library for building admin dashboards. Includes charts, tables, forms, and navigation components with Storybook documentation.',
                'is_featured' => false,
                'view_count'  => 189,
                'categories'  => ['Teknik', 'Desain'],
                'score'       => 90,
                'feedback'    => 'Well-organized component library with good documentation. Code quality is excellent.',
            ],
            // Marcus Johnson
            [
                'student_idx' => 2,
                'title'       => 'Full-Stack E-commerce API',
                'type'        => 'dokumen',
                'description' => 'A complete RESTful API for an e-commerce platform built with Laravel. Features include authentication, product management, cart, checkout, and payment integration with comprehensive API documentation.',
                'is_featured' => true,
                'view_count'  => 420,
                'categories'  => ['Teknik'],
                'score'       => 95,
                'feedback'    => 'Exceptional API design with proper authentication, validation, and documentation. Production-ready quality.',
            ],
            [
                'student_idx' => 2,
                'title'       => 'Blog CMS with Vue.js',
                'type'        => 'desain',
                'description' => 'A modern content management system built with Vue.js frontend and Laravel backend. Features markdown editor, tag system, and SEO optimization.',
                'is_featured' => false,
                'view_count'  => 156,
                'categories'  => ['Teknik'],
                'score'       => 87,
                'feedback'    => 'Good full-stack implementation. Frontend could benefit from more polished design.',
            ],
            // Elena Rodriguez
            [
                'student_idx' => 3,
                'title'       => 'Urban Renewal Pavilion Concept',
                'type'        => 'desain',
                'description' => 'Architectural concept for a community pavilion in an urban renewal zone. The design emphasizes sustainable materials, natural lighting, and community gathering spaces.',
                'is_featured' => true,
                'view_count'  => 198,
                'categories'  => ['Arsitektur', 'Desain'],
                'score'       => 88,
                'feedback'    => 'Creative concept with strong sustainability focus. Technical drawings are well-executed.',
            ],
            [
                'student_idx' => 3,
                'title'       => 'Minimalist Cafe Interior',
                'type'        => 'desain',
                'description' => 'Interior design project for a minimalist cafe concept. Includes floor plan, 3D renders, material selection, and furniture layout.',
                'is_featured' => false,
                'view_count'  => 134,
                'categories'  => ['Arsitektur'],
                'score'       => 85,
                'feedback'    => 'Beautiful minimalist aesthetic. Space planning is efficient and inviting.',
            ],
            // Emily Rodriguez
            [
                'student_idx' => 4,
                'title'       => 'Modernist Literature Analysis',
                'type'        => 'dokumen',
                'description' => 'A comprehensive literary analysis of modernist authors including Virginia Woolf, James Joyce, and T.S. Eliot. Explores themes of consciousness, time, and identity in early 20th-century literature.',
                'is_featured' => true,
                'view_count'  => 276,
                'categories'  => ['Penulisan'],
                'score'       => 98,
                'feedback'    => 'Brilliant analysis with deep understanding of the literary movement. Exceptional academic writing quality.',
            ],
            [
                'student_idx' => 4,
                'title'       => 'Startup Pitch Deck: EduTech',
                'type'        => 'presentasi',
                'description' => 'A professional pitch deck for a fictional educational technology startup. Covers problem statement, solution, market analysis, business model, and financial projections.',
                'is_featured' => false,
                'view_count'  => 112,
                'categories'  => ['Bisnis', 'Penulisan'],
                'score'       => 91,
                'feedback'    => 'Well-structured pitch with compelling narrative and realistic projections.',
            ],
            [
                'student_idx' => 4,
                'title'       => 'Photography Portfolio: Urban Life',
                'type'        => 'fotografi',
                'description' => 'A curated collection of urban photography capturing daily life, architecture, and street scenes in Indonesian cities.',
                'is_featured' => false,
                'view_count'  => 89,
                'categories'  => ['Fotografi'],
                'score'       => null,
                'feedback'    => null,
            ],
        ];

        $categoryMap = $categories->keyBy('name');

        foreach ($portfoliosData as $pData) {
            $portfolio = Portfolio::create([
                'student_id'  => $students[$pData['student_idx']]->id,
                'title'       => $pData['title'],
                'slug'        => Str::slug($pData['title']),
                'type'        => $pData['type'],
                'description' => $pData['description'],
                'is_featured' => $pData['is_featured'],
                'view_count'  => $pData['view_count'],
            ]);

            // Attach categories
            $catIds = collect($pData['categories'])->map(fn ($c) => $categoryMap[$c]->id)->toArray();
            $portfolio->categories()->attach($catIds);

            // Create assessment if scored
            if ($pData['score'] !== null) {
                PortfolioAssessment::create([
                    'portfolio_id' => $portfolio->id,
                    'admin_id'     => $admin->id,
                    'score'        => $pData['score'],
                    'feedback'     => $pData['feedback'],
                    'assessed_at'  => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // ═══════════════════════════════════════
        // 5. CV DOCUMENTS (sample)
        // ═══════════════════════════════════════
        $cv = CvDocument::create([
            'student_id'    => $students[0]->id, // Sarah Jenkins
            'template_name' => 'professional',
            'ai_summary'    => 'Highly creative and detail-oriented Interaction Design student with a strong portfolio in UI/UX design, branding, and user research. Demonstrates excellence in creating meaningful digital experiences with a focus on accessibility and visual aesthetics.',
        ]);

        // Attach Sarah's scored portfolios to CV
        $sarahPortfolios = Portfolio::where('student_id', $students[0]->id)
            ->whereHas('assessments')
            ->pluck('id');
        $cv->portfolios()->attach($sarahPortfolios);

        // ═══════════════════════════════════════
        // 6. HELP MESSAGES
        // ═══════════════════════════════════════
        HelpMessage::insert([
            [
                'name'       => 'Budi Santoso',
                'email'      => 'budi@gmail.com',
                'message'    => 'Bagaimana cara mengubah foto profil? Saya sudah mencoba tetapi tidak berhasil.',
                'status'     => 'resolved',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(3),
            ],
            [
                'name'       => 'Rina Wati',
                'email'      => 'rina.w@yahoo.com',
                'message'    => 'Apakah bisa menambahkan video YouTube sebagai karya di portfolio?',
                'status'     => 'read',
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(1),
            ],
            [
                'name'       => 'Ahmad Fauzi',
                'email'      => 'ahmad.f@school.edu',
                'message'    => 'Fitur Generate CV sangat membantu! Tapi saya ingin ada template yang lebih kreatif untuk siswa jurusan desain. Terima kasih.',
                'status'     => 'new',
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'name'       => 'Diana Putri',
                'email'      => 'diana.p@gmail.com',
                'message'    => 'Saya dari perusahaan X. Bagaimana cara menghubungi siswa yang karyanya kami minati?',
                'status'     => 'new',
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info("   Admin: admin@scholarchive.id / password");
        $this->command->info("   Students: s.jenkins@school.edu / password (and 4 others)");
        $this->command->info("   Categories: " . implode(', ', $categoryNames));
        $this->command->info("   Portfolios: " . Portfolio::count() . " works created");
        $this->command->info("   Help Messages: " . HelpMessage::count() . " messages");
    }
}
