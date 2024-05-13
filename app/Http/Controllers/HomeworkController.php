<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHomeworkController;
use App\Http\Requests\StoreHomeworkRequest;
use App\Http\Requests\UpdateHomeworkRequest;
use App\Models\Homework;
use App\Models\HomeworkQuestion;
use App\Models\HomeworkResult;
use App\Models\Question;
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
        $questions = Question::orderBy('id', 'desc')->get();

        return view('homework.add', compact('questions'));
    }

    public function store(StoreHomeworkRequest $request) {
        $homework = Homework::create([
            'homework_name' => $request->homework_name,
            'time' => $request->time,
            'end_time' => $request->end_time,
        ]);

        foreach($request->questions as $questionId) {
            HomeworkQuestion::create([
                'homework_id'=> $homework->id,
                'question_id' => $questionId,
            ]);
        }

        flash()->addSuccess('Cập nhật thông tin thành công');

        return redirect()->route('homework.index');
    }

    public function show($id)
    {
        $homework = Homework::findOrFail($id);
        $allQuestions = Question::orderBy('id', 'desc')->get();

        $questionIds = $homework->questions->pluck('id');

        return view('homework.edit', compact('homework', 'allQuestions', 'questionIds'));
    }

    public function update(UpdateHomeworkRequest $request, $id)
    {
        unset($request['_token'], $request['_method']);

        Homework::where('id', $id)->update([
            'homework_name' => $request->homework_name,
            'time' => $request->time,
            'end_time' => $request->end_time,
        ]);

        $homework = Homework::findOrFail($id);

        foreach ($homework->homeworkQuestions as $homeworkQuestion) {
            $homeworkQuestion->delete();
        }

        foreach($request->questions as $questionId) {
            HomeworkQuestion::create([
                'homework_id'=> $homework->id,
                'question_id' => $questionId,
            ]);
        }

        flash()->addSuccess('Cập nhật thông tin thành công');
        return redirect()->route('homework.index');
    }

    public function destroy($id)
    {
        Homework::where('id', $id)->delete();

        flash()->addSuccess('Xóa thông tin thành công.');
        return redirect()->route('homework.index');
    }

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
