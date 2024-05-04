<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class TeacherController extends Controller
{
    public function listApi()
    {
        $teachers = User::where('role', 2)->get();

        return $teachers;
    }

    public function index()
    {
        $teachers = User::where('role', 2)->paginate(5)->withQueryString();

        return view('teacher.index', compact('teachers'));
    }

    public function create() {
        return view('teacher.add');
    }

    public function store(StoreUserRequest $request) {
        $request['role'] = 2;
        $request['password'] = Hash::make('password');
        $user = User::create($request->all());

        flash()->addSuccess('Thêm thông tin thành công.');
        return redirect()->route('teacher.index');
    }

    public function show($id)
    {
        $teacher = User::findOrFail($id);

        return view('teacher.edit', compact('teacher'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        unset($request['_token'], $request['_method']);
        $user = User::where('id', $id)->update($request->all());

        flash()->addSuccess('Cập nhật thông tin thành công');
        return redirect()->route('teacher.index');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        flash()->addSuccess('Xóa thông tin thành công.');
        return redirect()->route('teacher.index');
    }
}
