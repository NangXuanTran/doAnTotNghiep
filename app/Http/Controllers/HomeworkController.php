<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\HomeworkResult;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function index(Request $request)
    {
        $homeworks = Homework::paginate(10)->withQueryString();

        return view('homework.index', compact('homeworks'));
    }

    public function create()
    {
        return view('homework.add');
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

    public function listApi(Request $request)
    {
        $homeworks = Homework::with('classroom')->get();
        foreach ($homeworks as $homework) {
            $homework['teacher'] = $homework->classroom->teacher->name;
            $homework['nameClass'] = $homework->classroom->name;
            $homework['assignmentName'] = $homework->homework_name;
            unset($homework['homework_name'], $homework['created_at'], $homework['updated_at']);
            $homeworkResult = HomeworkResult::where('homework_id', $homework->id)
                ->where('student_id', $request->user()->id)->orderBy('id', 'desc')
                ->first();
            $homework['count_question'] = count($homework->questions);
            $homework['is_finished'] = $homeworkResult ? $homeworkResult->is_finished : 0;
            $homework['score'] = $homeworkResult?->score;
        }

        return $homeworks;
    }

    public function listQuestionApi(Request $request, $homework_id)
    {
        $questions = Homework::find($homework_id)->questions;
        foreach ($questions as $question) {
            $question['option'] = [
                $question->option_1,
                $question->option_2,
                $question->option_3,
                $question->option_4,
            ];
            $question['answer'] = $question[$question->answer];
            unset($question['option_1'],
                $question['option_2'],
                $question['option_3'],
                $question['option_4'],
                $question['created_at'],
                $question['updated_at']
            );
        }

        return $questions;
    }

    public function storeResultApi(Request $request)
    {
        $request['score'] = $request->count_correct / $request->count_question * 100;
        $request['is_finished'] = 1;
        unset($request['count_correct'], $request['count_question']);
        $resultHomework = HomeworkResult::createOrFirst($request->all());

        return $resultHomework;
    }
}
