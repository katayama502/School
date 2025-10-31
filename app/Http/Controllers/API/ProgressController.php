<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProgressController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if ($user->role === 'guardian') {
            $studentId = $request->input('student_id');
            if ($studentId && $user->guardian?->students()->where('students.id', $studentId)->exists()) {
                return response()->json(Progress::where('student_id', $studentId)->with('lesson')->get());
            }
        }

        if (! $student) {
            return response()->json([], Response::HTTP_OK);
        }

        return response()->json($student->progress()->with('lesson')->get());
    }
}
