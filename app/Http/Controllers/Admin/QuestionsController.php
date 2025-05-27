<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\ActivityType;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function show(Activities $activities, ActivityType $activityType)
    {
        $activityType->load('questions.answers');

        return inertia('admin/questions/Show', [
           'activityType' => $activityType,
           'activity' => $activities,
        ]);
    }

    public function store(Request $request, ActivityType $activityType)
    {


        request()->validate([
            'question' => 'required|string|max:255',
            'timer' => 'required|integer|min:1|max:60',
            'point' => 'required|integer|min:1|max:20',
        ]);

        Question::create([
            'activity_type_id' => $activityType->id,
            'question' => $request->question,
            'point' => $request->point,
            'timer' => $request->timer,
            'is_response_ia' => $request->is_response_ia,
        ]);

    }
}
