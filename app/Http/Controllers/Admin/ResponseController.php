<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function store(Request $request, $activityType)
    {

        $request->validate([
            'responses' => 'required|array|min:3',
            'responses.*.answer' => 'required|string|max:255',
            'responses.*.is_correct' => 'boolean',
        ]);

        $answers = $request->responses;

         foreach ($answers as $answer) {
            // Create or update the answer
            Answer::create([
               'question_id' => $activityType,
                'answer' => $answer['answer'] ?? '',
                'is_correct' => $answer['is_correct'] ?? false,
            ]);

        }
    }

    public function remove(Answer $answer)
    {
        $answer->delete();
    }
}
