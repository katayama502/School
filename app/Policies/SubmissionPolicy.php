<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;

class SubmissionPolicy
{
    public function view(User $user, Submission $submission): bool
    {
        if ($user->role === 'admin' || $user->role === 'coach') {
            return true;
        }

        if ($user->role === 'student') {
            return $user->student?->id === $submission->student_id;
        }

        if ($user->role === 'guardian') {
            return $user->guardian?->students()->where('student_id', $submission->student_id)->exists() ?? false;
        }

        return false;
    }

    public function update(User $user, Submission $submission): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'student') {
            return $user->student?->id === $submission->student_id;
        }

        if ($user->role === 'coach') {
            return true;
        }

        return false;
    }
}
