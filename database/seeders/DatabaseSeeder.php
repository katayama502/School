<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\Guardian;
use App\Models\Lesson;
use App\Models\ScratchProject;
use App\Models\Student;
use App\Models\Submission;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $coach = User::factory()->create([
            'name' => 'Coach User',
            'email' => 'coach@example.com',
            'role' => 'coach',
            'password' => Hash::make('password'),
        ]);

        $studentUser = User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);

        $guardianUser = User::factory()->create([
            'name' => 'Guardian User',
            'email' => 'guardian@example.com',
            'role' => 'guardian',
            'password' => Hash::make('password'),
        ]);

        $student = Student::create([
            'user_id' => $studentUser->id,
            'display_name' => 'クリエット太郎',
            'grade' => 'G4',
            'guardian_linked' => true,
        ]);

        $guardian = Guardian::create([
            'user_id' => $guardianUser->id,
            'phone' => '000-0000-0000',
            'notice_prefs' => ['email' => true, 'sms' => false],
        ]);

        $guardian->students()->attach($student->id, ['relation' => 'parent']);

        $course = Course::create([
            'title' => 'Python 入門',
            'description' => 'Python と Scratch を使った入門コース',
            'is_published' => true,
            'order' => 1,
        ]);

        $unit = Unit::create([
            'course_id' => $course->id,
            'title' => 'ステップ 1',
            'order' => 1,
        ]);

        $lessons = collect([
            ['title' => 'はじめての Python', 'order' => 1],
            ['title' => '条件分岐に挑戦', 'order' => 2],
            ['title' => 'ループで繰り返し', 'order' => 3],
        ])->map(function ($data) use ($unit) {
            return Lesson::create([
                'unit_id' => $unit->id,
                'title' => $data['title'],
                'order' => $data['order'],
                'material_url' => 'https://example.com/materials/' . $data['order'],
                'template_code' => "print('Lesson {$data['order']}')",
            ]);
        });

        $assignments = $lessons->flatMap(function ($lesson) {
            return collect(range(1, 2))->map(function ($index) use ($lesson) {
                return Assignment::create([
                    'lesson_id' => $lesson->id,
                    'title' => $lesson->title . " 課題 {$index}",
                    'due_at' => now()->addDays($lesson->order + $index),
                    'rubric' => [
                        'clarity' => 5,
                        'syntax' => 5,
                    ],
                ]);
            });
        });

        Submission::create([
            'student_id' => $student->id,
            'assignment_id' => $assignments->first()->id,
            'type' => 'code',
            'status' => 'submitted',
            'score' => 85,
            'feedback' => 'よくできました！',
            'content_ref' => 'storage/submissions/hello.py',
            'run_stats' => [
                'cpu_ms' => 120,
                'mem_kb' => 2048,
                'timed_out' => false,
            ],
        ]);

        ScratchProject::create([
            'student_id' => $student->id,
            'lesson_id' => $lessons->first()->id,
            'title' => 'Cat Runner',
            'json_path' => 'storage/scratch/cat-runner.json',
            'visibility' => 'draft',
            'version' => 1,
            'payload' => '{"targets": []}',
        ]);

        $class = CourseClass::create([
            'name' => 'Python クラス',
            'coach_id' => $coach->id,
            'description' => '小学生向け Python クラス',
        ]);

        $class->students()->attach($student->id);
    }
}
