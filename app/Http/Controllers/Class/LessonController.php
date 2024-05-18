<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Models\Classroom;
use App\Models\Homework;
use App\Models\Lesson;
use App\Models\LessonHomework;
use Carbon\Carbon;
use DateTime;
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
        return view('class-component.lesson.index', compact('class', 'lessons'));
    }

    public function create(Request $request, $id)
    {
        $class = Classroom::findOrFail($id);
        $homeworks = Homework::all();

        return view('class-component.lesson.add', compact('homeworks', 'class'));
    }

    public function store(StoreLessonRequest $request, $id)
    {
        $homeworkIds = $request->homeworks;

        $request['start_time'] = Carbon::createFromFormat('d/m/Y H:i', $request['start_time']);
        if (!$request['start_time']->isAfter(Carbon::now())) {
            flash()->addError('Thời gian bắt đầu phải sau thời điểm hiện tại!');

            return redirect()->route('class_lesson.create', $id);
        }

        $request['end_time'] = $request['start_time']->addMinute($request['time']);
        $request['classroom_id'] = $id;
        dd($request->all(), $request['end_time'], $request['start_time']);
        unset($request['time']);
        $lesson = Lesson::create($request->all());
        foreach ($homeworkIds as $homeworkId) {
            LessonHomework::create([
                'homework_id' => $homeworkId,
                'lesson_id' => $lesson->id,
            ]);
        }

        flash()->addSuccess('Cập nhật thông tin thành công');

        return redirect()->route('class_lesson.index', $id);
    }

    public function show(Request $request, $class_id, $lesson_id)
    {
        $class = Classroom::findOrFail($class_id);
        $lesson = Lesson::where('id', $lesson_id)->where('classroom_id', $class_id)->first();
        // $lesson['start_time']
        $homeworks = Homework::all();
        $homeworkIds = $lesson->homeworks->pluck('id');
        $lesson->start_time = Carbon::parse($lesson->start_time)->format('d/m/Y H:i');
        dd($lesson);

        return view('class-component.lesson.edit', compact('lesson', 'homeworkIds', 'class', 'homeworks'));
    }
}
