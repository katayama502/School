<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Runner\RunCodeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RunnerController extends Controller
{
    public function __construct(private RunCodeService $runCodeService)
    {
    }

    public function execute(Request $request)
    {
        $data = $request->validate([
            'language' => 'required|in:python,php',
            'source' => 'required|string',
            'stdin' => 'nullable|string',
            'submission_id' => 'nullable|exists:submissions,id',
        ]);

        $result = $this->runCodeService->execute(
            $data['language'],
            $data['source'],
            $data['stdin'] ?? '',
            $data['submission_id'] ?? null
        );

        return response()->json($result, Response::HTTP_CREATED);
    }
}
