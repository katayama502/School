<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    public function view(User $user, Lesson $lesson): bool
    {
        if ($user->role === 'admin' || $user->role === 'coach') {
            return true;
        }

        $course = $lesson->unit?->course;

        if ($user->role === 'student' || $user->role === 'guardian') {
            return (bool) $course?->is_published;
        }

        return false;
    }

    public function update(User $user, Lesson $lesson): bool
    {
        return in_array($user->role, ['admin', 'coach'], true);
    }
}
