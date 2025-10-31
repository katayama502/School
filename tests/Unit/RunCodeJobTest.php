<?php

use App\Jobs\RunCodeJob;
use App\Services\Runner\RunCodeService;
use Mockery;

test('run code job dispatches service', function () {
    $service = Mockery::mock(RunCodeService::class);
    $service->shouldReceive('execute')->once();

    $job = new RunCodeJob('python', "print('hi')");
    $job->handle($service);
});
