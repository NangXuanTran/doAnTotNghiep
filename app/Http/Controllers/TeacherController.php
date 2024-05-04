<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Exception;

class TeacherController extends Controller
{
    public function listApi()
    {
        $teachers = User::where('role', 2)->get();

        return $teachers;
    }

    public function index()
    {
        $teachers = User::where('role', 2)->orderBy('id', 'desc')->paginate(5)->withQueryString();

        return view('teacher.index', compact('teachers'));
    }

    public function create() {
        return view('teacher.add');
    }

    public function store(StoreUserRequest $request) {
        $request['role'] = 2;
        $request['password'] = Hash::make('password');
        $request['image_url'] = $this->upload($request);

        unset($request['image']);
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
        if($request->file('image')) {
            $request['image_url'] = $this->upload($request);
        }
        unset($request['image']);

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
        $fileName = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);

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
