<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function detailApi(Request $request, $lesson_id)
    {
        $lesson = Lesson::where('id', $request->lesson_id)->with(['classroom', 'room'])->first();

        return $lesson;
    }
}
