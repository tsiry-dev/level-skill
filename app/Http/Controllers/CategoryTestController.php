<?php

namespace App\Http\Controllers;

use App\Models\CategoryTest;
use App\Support\StrHelper;
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
        ], [
            'name.required' => 'Le nom est requis',
            'name.unique' => 'Ce category existe déjà',
        ]);


        CategoryTest::create([
            'name' => $validated['name'],
            'slug' => StrHelper::slug($validated['name']),
        ]);

    }

    public function update(CategoryTest $categoryTest)
    {
        $validated = request()->validate([
           'name' => 'required|string|max:255|unique:category_tests,name',
        ]);

         $categoryTest->update([
             'name' => request()->name,
             'slug' => StrHelper::slug(request()->name),
         ]);
         return to_route('admin.categories.index');
    }

    public function destroy(CategoryTest $categoryTest)
    {

        // dd($categoryTest);
        $categoryTest->delete();
    }
}
