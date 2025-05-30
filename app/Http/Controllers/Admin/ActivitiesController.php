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

       $activity->load([
            'activityTypes',
            'categoryTest'
       ]);


       return inertia('admin/tests/Show', [
            'activity' => $activity
       ]);
    }

    public function update(Request $request, Activities $activity)
    {

        $activity->update([
            'title' => $request->name,
            'slug' => Activities::slug($request->name),
        ]);

        return to_route('admin.tests.all');
    }

    public function remove(Activities $activity)
    {
        $activity->delete();

        return to_route('admin.tests.all', $activity);
    }

}
