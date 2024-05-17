<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Classroom;
use App\Models\HomeworkResult;
use App\Models\Lesson;

class StudentController extends Controller
{
    public function index(Request $request, $id)
    {
        $class = Classroom::where('teacher_id', $request->user()->id)->where('id', $id)->first();
        $lessonIds = $class->lessons()->pluck('id')->toArray();
        $homeworkIds = $class->homeworks()->pluck('id')->toArray();
        $users = $class->students()->paginate(10)->withQueryString();
        foreach($class->students as $key =>  $student)
        {
            $users[$key]["count_attendance"] = count(Attendance::whereIn('lesson_id', $lessonIds )
                ->where('student_id', $student->id)
                ->where('status', 0)
                ->get());
            $users[$key]['count_lesson'] = count(Lesson::where('classroom_id', $class->id )
                ->where('end_time', '<', now())
                ->get());
            $users[$key]['count_homework'] = count($homeworkIds);
            $users[$key]["count_homework_finished"] = count(HomeworkResult::whereIn('homework_id', $lessonIds )
                ->where('student_id', $student->id)
                ->where('is_finished', 1)
                ->get());
        }
        return view('class-component.student.index', compact('users'));
    }
}
