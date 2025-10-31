<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if ($user->role === 'guardian') {
            $studentId = $request->input('student_id');
            if ($studentId && $user->guardian?->students()->where('students.id', $studentId)->exists()) {
                $student = $user->guardian->students()->where('students.id', $studentId)->first();
            }
        }

        if (! $student) {
            return response()->json([], Response::HTTP_FORBIDDEN);
        }

        $pendingAssignments = Assignment::whereDoesntHave('submissions', function ($query) use ($student) {
            $query->where('student_id', $student->id)->where('status', 'submitted');
        })->take(5)->get();

        $recentFeedback = Submission::where('student_id', $student->id)
            ->whereNotNull('feedback')
            ->latest()
            ->take(5)
            ->get();

        $progress = $student->progress()->avg('percent') ?? 0;

        return response()->json([
            'pending_assignments' => $pendingAssignments,
            'recent_feedback' => $recentFeedback,
            'progress_percent' => (int) $progress,
        ]);
    }
}
