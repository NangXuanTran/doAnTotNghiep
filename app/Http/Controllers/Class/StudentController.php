<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classroom;


class StudentController extends Controller
{
    public function index(Request $request, $class_id)
    {
        $class = Classroom::where('teacher_id', $request->user()->id)->where('id', $class_id)->first();
        $users = $class->students()->paginate(10)->withQueryString();
        // dd($users);
        // dd($request->user()->id);
        return view('class-component.student.index', compact('users'));
    }
}
