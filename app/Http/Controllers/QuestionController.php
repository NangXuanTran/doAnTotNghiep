<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Room;
use Exception;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('question.index', compact('questions'));
    }

    public function create() {
        return view('student.add');
    }

    // public function store(StoreUserRequest $request) {
    //     $request['role'] = 3;
    //     $request['password'] = Hash::make('password');
    //     $request['image_url'] = $this->upload($request);

    //     unset($request['image']);
    //     $user = User::create($request->all());

    //     flash()->addSuccess('Thêm thông tin thành công.');
    //     return redirect()->route('user.index');
    // }

    // public function show($id)
    // {
    //     $user = User::findOrFail($id);

    //     return view('student.edit', compact('user'));
    // }

    // public function update(UpdateUserRequest $request, $id)
    // {
    //     unset($request['_token'], $request['_method']);
    //     if($request->file('image')) {
    //         $request['image_url'] = $this->upload($request);
    //     }
    //     unset($request['image']);

    //     $user = User::where('id', $id)->update($request->all());

    //     flash()->addSuccess('Cập nhật thông tin thành công');
    //     return redirect()->route('user.index');
    // }

    // public function destroy($id)
    // {
    //     User::where('id', $id)->delete();

    //     flash()->addSuccess('Xóa thông tin thành công.');
    //     return redirect()->route('user.index');
    // }

    // public function upload($request)
    // {
    //     $file = $request->file('image');

    //     try {
    //         return $this->uploadImage($file);
    //     } catch (Exception $e) {
    //         return false;
    //     }
    // }

    // public function uploadImage($file)
    // {
    //     $fileName = $file->getClientOriginalName();
    //     $file->move(public_path('uploads'), $fileName);

    //     $imageUrl = url('uploads/' . $fileName);
    //     return $imageUrl;
    // }

    // public function prepairFolder()
    // {
    //     $year = date('Y');
    //     $month = date('m');
    //     $storagePath = "$year/$month/";

    //     if (! file_exists($storagePath)) {
    //         mkdir($storagePath, 0755, true);
    //     }

    //     return $storagePath;
    // }
}
