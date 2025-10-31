<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        return response()->json($lesson);
    }
}
