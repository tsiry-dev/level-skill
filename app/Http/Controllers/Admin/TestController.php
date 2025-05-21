<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {


        $activities = Activities::withCount('activityTypes')->get();

        return  inertia('admin/tests/TestView', [
            'activities' => $activities
        ]);
    }

    public function create()
    {
        return inertia('admin/tests/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Activities::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
        ]);

        return to_route('admin.test.create');
    }
}
