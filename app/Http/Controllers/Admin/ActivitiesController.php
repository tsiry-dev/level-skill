<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\ActivityType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
{
    public function show(?Activities $activity)
    {

       $activity->load('activityTypes');

       return inertia('admin/tests/Show', [
            'activity' => $activity
       ]);
    }

    public function showActivityType(Activities $activity, ActivityType $activityType)
    {

        $activityType->load('questions.answers');

        return inertia('admin/activities/Show', [
            'activityType' => $activityType
        ]);
    }

    public function store(Request $request, Activities $activity)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ActivityType::create([
            'activity_id' => $activity->id,
            'name' => $request->name,
            'slug' => ActivityType::slug($request->name),
        ]);

         return to_route('admin.activitie.show',  $activity)
           ->with('success', 'Type d\'activité créé avec succès');
    }

    public function destroy(Activities $activity, ActivityType $activityType)
    {

        $activityType->delete();

        return to_route('admin.activitie.show',  $activity)
           ->with('success', 'Type d\'activité supprimé avec succès');
    }
}
