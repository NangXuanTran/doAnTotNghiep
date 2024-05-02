<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Models\HomeworkResult;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    public function listApi(Request $request)
    {
        $homeworks = Homework::with('classroom')->get();
        foreach ($homeworks as $homework) {
            $homework['teacher'] = $homework->classroom->teacher->name;
            $homework['nameClass'] = $homework->classroom->name;
            $homework['assignmentName'] = $homework->homework_name;
            unset($homework['homework_name'], $homework['created_at'], $homework['updated_at']);
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
        unset($request['count_correct'], $request['count_question']);
        $resultHomework = HomeworkResult::createOrFirst($request->all());

        return $resultHomework;
    }
}
