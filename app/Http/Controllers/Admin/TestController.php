<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\CategoryTest;
use App\Support\StrHelper;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {


        $activities = Activities::withCount('activityTypes')->get();
        $activities->load([
           'CategoryTest'
        ]);

        return  inertia('admin/tests/TestView', [
            'activities' => $activities
        ]);
    }

    public function create()
    {

        $categoryTests = CategoryTest::all();

        return inertia('admin/tests/Create', [
            'categoryTests' => $categoryTests
        ]);
    }

    public function store(Request $request)
    {


        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);


        Activities::create([
            'category_test_id' => $request->type,
            'title' => $request->title,
            'slug' => StrHelper::slug($request->title),
            'description' => $request->description,
        ]);

        return to_route('admin.tests.create');
    }
}
