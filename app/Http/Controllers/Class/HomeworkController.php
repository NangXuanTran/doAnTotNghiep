<?php

namespace App\Http\Controllers\Class;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index(Request $request, $id) {
        $class = Classroom::where('teacher_id', $request->user()->id)->where('id', $id)->first();
        $users = $class->students()->paginate(10)->withQueryString();

        return view('class-component.student.index', compact('users'));
    }
}
