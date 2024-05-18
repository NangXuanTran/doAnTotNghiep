<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\ClassroomStudent;
use App\Models\Lesson;
use App\Models\Room;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role == 1) {
            $classes = Classroom::orderBy('id', 'desc')->paginate(10)->withQueryString();
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

    public function create()
    {
        $students = User::where('role', 3)->orderBy('id', 'desc')->get();
        $rooms = Room::all();
        $teachers = User::where('role',2)->orderBy('id','desc')->get();

        return view('class.add', compact('students', 'rooms', 'teachers'));
    }

    public function store(StoreClassRequest $request)
    {
        $studentIds = $request->students;
        unset($request['students']);
        $class = Classroom::create($request->all());

        foreach($studentIds as $studentId) {
            ClassroomStudent::create([
                'classroom_id' => $class->id,
                'student_id' => $studentId,
            ]);
        }

        flash()->addSuccess('Cập nhật thông tin thành công');

        return redirect()->route('class.index');
    }

    public function show(Request $request, $id) {
        $class = Classroom::findOrFail($id);
        $students = User::where('role', 3)->orderBy('id', 'desc')->get();
        $rooms = Room::all();
        $teachers = User::where('role',2)->orderBy('id','desc')->get();
        $studentIds = $class->students->pluck('id');

        return view('class.edit', compact('class', 'students', 'rooms', 'teachers', 'studentIds'));
    }

    public function update(UpdateClassRequest $request, $id) {
        unset($request['_token'], $request['_method']);

        Classroom::where('id', $id)->update([
            'name' => $request->name,
            'teacher_id' => $request->teacher_id,
            'room_id' => $request->room_id,
            'fee' => $request->fee,
        ]);

        $class = Classroom::findOrFail($id);
        foreach ($class->classroomStudents as $classroomStudent) {
            $classroomStudent->delete();
        }

        foreach ($request->students as $studentId) {
            ClassroomStudent::create([
                'classroom_id' => $class->id,
                'student_id' => $studentId,
            ]);
        }

        flash()->addSuccess('Cập nhật thông tin thành công');

        return redirect()->route('class.index');
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
