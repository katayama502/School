<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with(['units' => function ($query) {
            $query->orderBy('order')->with(['lessons' => function ($lessonQuery) {
                $lessonQuery->orderBy('order');
            }]);
        }])->orderBy('order')->get();

        return response()->json($courses);
    }
}
