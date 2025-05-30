<?php

namespace App\Http\Controllers;

use App\Models\CategoryTest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryTestController extends Controller
{
    public function index()
    {
        $categoryTests = CategoryTest::all();
        $categoryTests->load([
            'activities'
        ]);


        return inertia('admin/categories/CategoryTest', [
            'categoryTests' => $categoryTests
        ]);
    }

    public function show(CategoryTest $categoryTest)
    {


        $categoryTest->load([
            'activities.activityTypes.questions',
        ]);

        return inertia('admin/categories/CategoryShow', [
            'categoryTest' => $categoryTest
        ]);
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:category_tests,name',
            'description' => 'required|string|max:255',
        ], [
            'name.required' => 'Le nom est requis',
            'description.required' => 'La description est requis',
            'name.unique' => 'Ce category existe déjà',
        ]);


        CategoryTest::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) .'-'. time() . mt_rand(200, 1500),
            'description' => $validated['description'],
        ]);

    }

    public function destroy(CategoryTest $categoryTest)
    {

        // dd($categoryTest);
        $categoryTest->delete();
    }
}
