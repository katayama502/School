<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Submission::query()->with('assignment');

        if ($user->role === 'student' && $user->student) {
            $query->where('student_id', $user->student->id);
        } elseif ($user->role === 'guardian' && $user->guardian) {
            $studentIds = $user->guardian->students()->pluck('students.id');
            $query->whereIn('student_id', $studentIds);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        return response()->json($query->latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'type' => 'required|in:code,scratch',
            'status' => 'required|in:draft,submitted',
            'content_ref' => 'nullable|string',
        ]);

        $data['student_id'] = $request->user()->student?->id;

        abort_unless($data['student_id'], Response::HTTP_FORBIDDEN);

        $submission = Submission::create($data);

        return response()->json($submission, Response::HTTP_CREATED);
    }

    public function update(Request $request, Submission $submission)
    {
        Gate::authorize('update', $submission);

        $data = $request->validate([
            'status' => 'nullable|in:draft,submitted,returned,accepted',
            'score' => 'nullable|integer|min:0|max:100',
            'feedback' => 'nullable|string',
            'content_ref' => 'nullable|string',
        ]);

        $submission->fill($data)->save();

        return response()->json($submission);
    }

    public function runs(Submission $submission)
    {
        Gate::authorize('view', $submission);

        return response()->json($submission->runs()->latest()->get());
    }
}
