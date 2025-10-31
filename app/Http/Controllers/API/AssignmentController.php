<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
        ]);

        $query = Assignment::query()->with('lesson');

        if (isset($validated['lesson_id'])) {
            $query->where('lesson_id', $validated['lesson_id']);
        }

        return response()->json($query->orderByDesc('updated_at')->paginate());
    }
}
