<?php

namespace App\Services\Runner;

use Symfony\Component\Process\Process;

class PseudoSandboxRunner implements SandboxRunner
{
    public function run(array $payload): array
    {
        $language = $payload['language'];
        $source = $payload['source'];
        $stdin = $payload['stdin'] ?? '';

        $extension = $language === 'python' ? 'py' : 'php';
        $executable = $language === 'python' ? 'python3' : 'php';

        $tempFile = tempnam(sys_get_temp_dir(), 'crietto_') . '.' . $extension;
        file_put_contents($tempFile, $source);

        $process = new Process([$executable, $tempFile]);
        $process->setInput($stdin);
        $process->setTimeout(3);
        $process->setIdleTimeout(3);

        $start = microtime(true);
        $process->run();
        $duration = (int) ((microtime(true) - $start) * 1000);

        @unlink($tempFile);

        return [
            'stdout' => $process->getOutput(),
            'stderr' => $process->getErrorOutput(),
            'exit_code' => $process->getExitCode() ?? 0,
            'cpu_ms' => $duration,
            'mem_kb' => 0,
            'timed_out' => $process->isTerminated() && $process->getExitCode() === 143,
        ];
    }
}
