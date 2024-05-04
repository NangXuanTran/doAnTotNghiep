<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 3)->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('student.index', compact('users'));
    }

    public function create() {
        return view('student.add');
    }

    public function store(StoreUserRequest $request) {
        $request['role'] = 3;
        $request['password'] = Hash::make('password');
        $request['image_url'] = $this->upload($request);

        unset($request['image']);
        $user = User::create($request->all());

        flash()->addSuccess('Thêm thông tin thành công.');
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

    public function upload($request)
    {
        $file = $request->file('image');

        try {
            return $this->uploadImage($file);
        } catch (Exception $e) {
            return false;
        }
    }

    public function uploadImage($file)
    {
        $fileName = $file->getClientOriginalName(); // Lấy tên gốc của file
        $file->move(public_path('uploads'), $fileName);

        // Tạo URL đầy đủ cho ảnh
        $imageUrl = url('uploads/' . $fileName);
        return $imageUrl;
    }

    public function prepairFolder()
    {
        $year = date('Y');
        $month = date('m');
        $storagePath = "$year/$month/";

        if (! file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }

        return $storagePath;
    }
}
