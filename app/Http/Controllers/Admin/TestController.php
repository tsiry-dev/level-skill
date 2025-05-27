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

        $categoryTests = \App\Models\CategoryTest::all();

        return inertia('admin/tests/Create', [
            'categoryTests' => $categoryTests
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'category_test_id' => 'required|exists:category_tests,id',
        ]);

        Activities::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . time(),
            'description' => $request->description,
        ]);

        return to_route('admin.tests.create');
    }
}
