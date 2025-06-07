<?php

namespace App\Http\Controllers;

use App\Models\Activities;
use App\Models\ActivityType;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TestController extends Controller
{
    public function index()
    {

        $resultats = Submission::where('user_id', Auth::user()->id)->get();
        $resultats->load('activityType');
        $resultats->load('activityType.activities');
        $resultats->load('user');


        return Inertia::render('account/TestView', [
            'resultats' => $resultats
        ]);
    }

    public function all()
    {


        $activities = Activities::all();

        return Inertia::render('account/AllTestView', [
            'activities' => $activities
        ]);

    }

    public function show(Activities $activity)
    {
        $activity->load([
            'activityTypes'
        ]);

        $activityTypeStory = DB::table('user_activitytype_story')->get();


        return inertia('account/ShowTest', [
            'activity' => $activity,
            'user' => Auth::user(),
            'activityTypeStory' => $activityTypeStory,
        ]);
    }

    public function showActivityType(Activities $activities,ActivityType $activityType)
    {

        $nbQuestion = $activityType->nb_question;

        // Charger aléatoirement les questions + leurs réponses
        $questions = $activityType->questions()
            ->inRandomOrder()
            ->with('answers')
            ->limit($nbQuestion)
            ->get();

        $activityType->load([
            'questions.answers'
        ]);

        return inertia('account/ShowActivityType', [
            'activityType' => $activityType,
            'questions' => $questions,
            'activities' => $activities,
            'user' => Auth::user(),
            'activityTypeStory' => DB::table('user_activitytype_story')->get(),
        ]);
    }

    public function storeTestStory(ActivityType $activityType)
    {

        if(Auth::check())
        {
            DB::table('user_activitytype_story')->insert([
                'user_id' => Auth::user()->id,
                'activity_type_id' => $activityType->id,
            ]);
        }

    }

    public function submission(Request $request, ActivityType $activityType)
    {

        $activityType->load(['questions']);

        DB::table('submissions')->insert([
            'user_id' => Auth::user()->id,
            'activity_type_id' => $activityType->id,
            'total' => $request['total'],
            'time' => $request['time']
        ]);
    }
}
