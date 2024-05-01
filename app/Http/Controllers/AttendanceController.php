<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Models\Attendance;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function listClassLessons(Request $request)
    {
        $classroomIds = User::find($request->user()->id)->classrooms->pluck('id')->toArray();
        $classrooms = Classroom::whereIn('id', $classroomIds)->with([
            'lessons' => function (Builder $query) {
                $query->whereNot('is_finished', 1);
            },
            'teacher'])->get();

        return $classrooms;
    }

    public function listApi()
    {
        $attendances = Attendance::all();
        foreach ($attendances as $attendance) {
            $attendance['lesson_name'] = $attendance->lesson->lesson_name;
            $attendance['classroom'] = $attendance->lesson->classroom;
            unset($attendance['created_at'], $attendance['updated_at']);
        }

        return $attendances;
    }

    public function storeApi(StoreAttendanceRequest $request)
    {
        $request['status'] = 1;

        $attendances = Attendance::create($request->all());

        return $attendances;
    }
}
