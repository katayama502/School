<?php

namespace App\Providers;

use App\Models\Lesson;
use App\Models\ScratchProject;
use App\Models\Submission;
use App\Policies\LessonPolicy;
use App\Policies\ScratchProjectPolicy;
use App\Policies\SubmissionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Submission::class => SubmissionPolicy::class,
        ScratchProject::class => ScratchProjectPolicy::class,
        Lesson::class => LessonPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
