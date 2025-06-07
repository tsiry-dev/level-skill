<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\ActivityType;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionsController extends Controller
{
    public function show(Activities $activities, ActivityType $activityType)
    {

        $activityType->load('questions.answers');

        // dd($activityType->questions);

        return inertia('admin/questions/Show', [
           'activityType' => $activityType,
           'activity' => $activities,
        ]);
    }

    public function store(Request $request, ActivityType $activityType)
    {

        $request->validate([
            'question' => 'required|string|max:255',
            'timer' => 'required|integer|min:1|max:60',
        ]);

        Question::create([
            'activity_type_id' => $activityType->id,
            'question' => $request->question,
            'point' => 2,
            'timer' => $request->timer,
            'is_response_ia' => $request->is_response_ia,
        ]);

    }

    public function updateCount(Request $request, ActivityType $activityType)
    {
        $totalAvailableQuestionCount = $activityType->questions()->count();

        $validated = $request->validate([
            'question_count' => [
                'required',
                'integer',
                'min:10',
                'max:' . $totalAvailableQuestionCount,
            ],
        ], [
            'max' => 'La réponse doit être inférieur qu nombre des question!! "' . $totalAvailableQuestionCount . '"'
        ]);

        $activityType->nb_question = $validated['question_count'];
        $activityType->save();


        $totalQuestion = (int) $validated['question_count'];
        $totalPoint = 20;
        $pointParQuestion = $totalPoint / $totalQuestion;
        $questions = Question::where('activity_type_id', $activityType->id)->get();

        foreach ($questions as $question) {
            $question->update([
                'point' => $pointParQuestion
            ]);
        }

        return back()->with('success', 'Nombre de questions et points mis à jour avec succès.');
    }


}
