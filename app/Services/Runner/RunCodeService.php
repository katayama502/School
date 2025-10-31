<?php

namespace App\Services\Runner;

use App\Models\CodeRun;

class RunCodeService
{
    public function __construct(private SandboxRunner $runner)
    {
    }

    public function execute(string $language, string $source, string $stdin = '', ?int $submissionId = null): array
    {
        $payload = [
            'language' => $language,
            'source' => $source,
            'stdin' => $stdin,
            'submission_id' => $submissionId,
        ];

        $result = $this->runner->run($payload);

        if ($submissionId) {
            CodeRun::create([
                'submission_id' => $submissionId,
                'language' => $language,
                'source_hash' => hash('sha256', $source),
                'stdout' => $result['stdout'],
                'stderr' => $result['stderr'],
                'exit_code' => $result['exit_code'],
                'cpu_ms' => $result['cpu_ms'],
                'mem_kb' => $result['mem_kb'],
                'timed_out' => $result['timed_out'],
            ]);
        }

        return $result;
    }
}
