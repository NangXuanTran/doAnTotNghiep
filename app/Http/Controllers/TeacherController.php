<?php

namespace App\Http\Controllers;

use App\Models\User;

class TeacherController extends Controller
{
    public function listApi()
    {
        $teachers = User::where('role', 2)->get();

        return $teachers;
    }
}
