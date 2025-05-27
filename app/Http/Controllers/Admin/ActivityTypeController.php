<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\ActivityType;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{
    public function showActivityType(Activities $activity, ActivityType $activityType)
    {

        $activityType->load([
            'questions.answers',
        ]);

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

         return to_route('admin.activities.show',  $activity);
    }

    public function update(Request $request, Activities $activity, ActivityType $activityType)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $activityType->update([
            'name' => $request->name,
            'slug' => ActivityType::slug($request->name),
        ]);

        return to_route('admin.activities.show', $activity);
    }

    public function destroy(Activities $activity, ActivityType $activityType)
    {

        $activityType->delete();

        return to_route('admin.activities.show',  $activity);
    }
}
