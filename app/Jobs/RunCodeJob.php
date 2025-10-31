<?php

namespace App\Jobs;

use App\Services\Runner\RunCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $language,
        public string $source,
        public string $stdin = '',
        public ?int $submissionId = null
    ) {
    }

    public function handle(RunCodeService $runCodeService): void
    {
        $runCodeService->execute($this->language, $this->source, $this->stdin, $this->submissionId);
    }
}
