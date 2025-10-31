<?php

namespace App\Services\Runner;

interface SandboxRunner
{
    /**
     * @param array{language:string,source:string,stdin?:string,submission_id?:int|null} $payload
     * @return array{stdout:string,stderr:string,exit_code:int,cpu_ms:int,mem_kb:int,timed_out:bool}
     */
    public function run(array $payload): array;
}
