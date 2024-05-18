<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function index(Request $request, $id)
    {
        $class = Classroom::findOrFail($id);
        $lessons = $class->lessons()->paginate(10)->withQueryString();
        foreach ($lessons as $lesson) {
            $lesson['attendance'] = count($lesson->attendances()->where('status', 0)->get());
            $lesson['is_finished'] = Carbon::now()->greaterThan($lesson->end_time) ? 1 : 0;
        }

        $homeworks = $class->homeworks()->paginate(10)->withQueryString();
        // dd($class->homeworks());

        return view('class-component.lesson.index', compact('class', 'lessons', 'homeworks'));
    }
}
