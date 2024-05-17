<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 1) {
            $classes = Classroom::paginate(10)->withQueryString();
        } else {
            $classes = Classroom::where('teacher_id', $request->user()->id)->paginate(10)->withQueryString();
        }
        foreach ($classes as $class) {
            $class['count_finished'] = count(Lesson::where('classroom_id', $class->id)
                ->where('end_time', '<', now())
                ->get());
        }

        return view('class.index', compact('classes'));
    }

    public function show(Request $request, $id)
    {
        $class = Classroom::findOrFail($id);
        $lessons = $class->lessons()->paginate(10)->withQueryString();
        foreach ($lessons as $lesson) {
            $lesson['attendance'] = count($lesson->attendances()->where('status', 0)->get());
            $lesson['is_finished'] = Carbon::now()->greaterThan($lesson->end_time) ? 1 : 0;
        }

        return view('class.detail', compact('class', 'lessons'));
    }

    //API
    public function getListApi(Request $request)
    {
        $classroomIds = User::find($request->user()->id)->classrooms->pluck('id')->toArray();
        $classrooms = Classroom::whereIn('id', $classroomIds)->with(['room', 'lessons' => ['documents'], 'teacher'])->get();

        $numberOfLessonsStudied = 0;
        foreach ($classrooms as $classroom) {
            $classroom['countLessons'] = count($classroom->lessons);
            foreach ($classroom->lessons as $lesson) {
                $numberOfLessonsStudied += $lesson['is_finished'];
                $attendenceStatus = Attendance::where('lesson_id', $lesson->id)->where('student_id', $request->user()->id)->first()?->status;
                $lesson['attendenceStatus'] = $attendenceStatus;
            }
            $classroom['numberOfLessonsStudied'] = $numberOfLessonsStudied;
            unset($classroom['created_at'],$classroom['updated_at']);
        }

        return $classrooms;
    }

    public function detailApi(Request $request, $class_id)
    {
        $classrooms = Classroom::where('id', $class_id)->with(['room', 'lessons' => ['documents'], 'teacher'])->get();

        $numberOfLessonsStudied = 0;
        foreach ($classrooms as $classroom) {
            $classroom['countLessons'] = count($classroom->lessons);
            foreach ($classroom->lessons as $lesson) {
                $numberOfLessonsStudied += $lesson['is_finished'];
                $attendenceStatus = Attendance::where('lesson_id', $lesson->id)->where('student_id', $request->user()->id)->first()?->status;
                $lesson['attendenceStatus'] = $attendenceStatus;
            }
            $classroom['numberOfLessonsStudied'] = $numberOfLessonsStudied;
        }

        return $classrooms;
    }

    public function getLessonTodayApi(Request $request)
    {
        $classroomIds = User::find($request->user()->id)->classrooms->pluck('id')->toArray();
        $classrooms = Classroom::whereIn('id', $classroomIds)->with(['room',
            'lessons' => function (Builder $query) {
                $query->whereDate('start_time', Carbon::today());
            },
            'teacher'])->get();

        $numberOfLessonsStudied = 0;
        foreach ($classrooms as $key => $classroom) {
            foreach ($classroom->lessons as $lesson) {
                $numberOfLessonsStudied += $lesson['is_finished'];
            }
            $classroom['numberOfLessonsStudied'] = $numberOfLessonsStudied;
        }

        return $classrooms;
    }

    public function getLessonScheduleTaskApi(Request $request)
    {
        $time = strtotime($request->datetime);
        $today = date('Y-m-d', $time);

        $user = User::where('id', $request->user()->id)->with([
            'classrooms' => [
                'room',
                'lessons' => function (Builder $query) use ($today) {
                    $query->whereDate('start_time', $today);
                },
                'teacher',
            ],
        ])->get();

        $classrooms = $user[0]['classrooms'];

        return $classrooms;
    }

    public function getTaskApi(Request $request)
    {
        $user = User::where('id', $request->user()->id)->with([
            'classrooms' => [
                'room',
                'homeworks' => function (Builder $query) {
                    $query->whereBetween('end_time', [Carbon::today(), Carbon::today()->addDays(3)]);
                },
                'teacher',
            ],
        ])->get();

        $classrooms = $user[0]['classrooms'];

        return $classrooms;
    }
}
