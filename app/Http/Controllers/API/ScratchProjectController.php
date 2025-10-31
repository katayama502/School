<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ScratchProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ScratchProjectController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'required|string|max:255',
            'json_path' => 'required|string',
            'thumbnail_path' => 'nullable|string',
            'visibility' => 'nullable|in:draft,private,shared',
            'payload' => 'nullable|string',
        ]);

        $student = $request->user()->student;
        abort_unless($student, Response::HTTP_FORBIDDEN);

        $data['student_id'] = $student->id;
        $project = ScratchProject::create($data);

        return response()->json($project, Response::HTTP_CREATED);
    }

    public function update(Request $request, ScratchProject $project)
    {
        Gate::authorize('update', $project);

        $data = $request->validate([
            'title' => 'sometimes|string|max:255',
            'json_path' => 'sometimes|string',
            'thumbnail_path' => 'nullable|string',
            'visibility' => 'nullable|in:draft,private,shared',
            'version' => 'nullable|integer|min:1',
        ]);

        $project->fill($data)->save();

        return response()->json($project);
    }

    public function show(ScratchProject $project)
    {
        Gate::authorize('view', $project);

        return response()->json($project);
    }
}
