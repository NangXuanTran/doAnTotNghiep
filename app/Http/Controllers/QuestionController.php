<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('question.index', compact('questions'));
    }

    public function create() {
        return view('question.add');
    }

    public function store(Request $request) {
        $request->validate([
            'question' => [
                'required',
                'string',
                'max:255',
            ],
            'option_1' => [
                'required',
                'string',
                'max:255',
            ],'option_2' => [
                'required',
                'string',
                'max:255',
            ],'option_3' => [
                'required',
                'string',
                'max:255',
            ],
            'option_4' => [
                'required',
                'string',
                'max:255',
            ],
            'answer' => [
                'required',
            ],

        ]);
        $question = Question::create($request->all());

        flash()->addSuccess('Thêm thông tin thành công.');
        return redirect()->route('question.index');
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('question.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => [
                'required',
                'string',
                'max:255',
            ],
            'option_1' => [
                'required',
                'string',
                'max:255',
            ],'option_2' => [
                'required',
                'string',
                'max:255',
            ],'option_3' => [
                'required',
                'string',
                'max:255',
            ],
            'option_4' => [
                'required',
                'string',
                'max:255',
            ],
            'answer' => [
                'required',
            ],

        ]);
        unset($request['_token'], $request['_method']);

        $question = Question::where('id', $id)->update($request->all());

        flash()->addSuccess('Cập nhật thông tin thành công');
        return redirect()->route('question.index');
    }

    public function destroy($id)
    {
        Question::where('id', $id)->delete();

        flash()->addSuccess('Xóa thông tin thành công.');
        return redirect()->route('question.index');
    }
}
