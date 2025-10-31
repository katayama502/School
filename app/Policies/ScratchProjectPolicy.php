<?php

namespace App\Policies;

use App\Models\ScratchProject;
use App\Models\User;

class ScratchProjectPolicy
{
    public function view(User $user, ScratchProject $project): bool
    {
        if ($user->role === 'admin' || $user->role === 'coach') {
            return true;
        }

        if ($user->role === 'student') {
            return $project->student_id === $user->student?->id || $project->visibility === 'shared';
        }

        if ($user->role === 'guardian') {
            return $user->guardian?->students()->where('student_id', $project->student_id)->exists() ?? false;
        }

        return false;
    }

    public function update(User $user, ScratchProject $project): bool
    {
        if ($user->role === 'admin' || $user->role === 'coach') {
            return true;
        }

        if ($user->role === 'student') {
            return $project->student_id === $user->student?->id;
        }

        return false;
    }
}
