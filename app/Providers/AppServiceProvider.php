<?php

namespace App\Providers;

use App\Services\Runner\PseudoSandboxRunner;
use App\Services\Runner\RunCodeService;
use App\Services\Runner\SandboxRunner;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SandboxRunner::class, PseudoSandboxRunner::class);
        $this->app->singleton(RunCodeService::class, function ($app) {
            return new RunCodeService($app->make(SandboxRunner::class));
        });
    }

    public function boot(): void
    {
    }
}
