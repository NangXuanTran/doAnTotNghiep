<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 3)->paginate(10)->withQueryString();

        return view('student.index', compact('users'));
    }

    public function create() {
        return view('student.add');
    }

    public function store(StoreUserRequest $request) {
        $request['role'] = 3;
        $request['password'] = Hash::make('password');
        $user = User::create($request->all());

        flash()->addSuccess('Thêm học viên thành công.');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('student.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        unset($request['_token'], $request['_method']);
        $user = User::where('id', $id)->update($request->all());

        flash()->addSuccess('Cập nhật thông tin thành công');
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        flash()->addSuccess('Xóa thông tin thành công.');
        return redirect()->route('user.index');
    }
}
