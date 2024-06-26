<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\HomeworkResult;
use App\Models\Lesson;
use App\Models\LessonHomework;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request->user()->role == 1) {
            $class = Classroom::where('id', $id)->first();
        } else {
            $class = Classroom::where('teacher_id', $request->user()->id)->where('id', $id)->first();
        }

        $lessonIds = $class->lessons()->pluck('id')->toArray();
        $lessonFinishedIds =Lesson::where('classroom_id', $class->id)
            ->where('end_time', '<', now())
            ->pluck('id');
        $homeworkIds = LessonHomework::whereIn('lesson_id', $lessonIds)->pluck('homework_id')->toArray();
        $users = $class->students()->paginate(10)->withQueryString();

        foreach ($class->students as $key => $student) {
            $users[$key]['count_attendance'] = count(Attendance::whereIn('lesson_id', $lessonIds)
                ->where('student_id', $student->id)
                ->where('status', 0)
                ->get());
            $users[$key]['count_lesson'] = count($lessonFinishedIds);

            $users[$key]['count_homework'] = count(LessonHomework::whereIn('lesson_id', $lessonFinishedIds)->get());

            $users[$key]['count_homework_finished'] = count(HomeworkResult::whereIn('homework_id', $lessonIds)
                ->where('student_id', $student->id)
                ->where('is_finished', 1)
                ->get());
        }

        return view('class-component.student.index', compact('users', 'class'));
    }
}
