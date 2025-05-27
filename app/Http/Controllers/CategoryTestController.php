<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryTestController extends Controller
{
    public function index()
    {
        $categoryTests = \App\Models\CategoryTest::all();


        return inertia('admin/categories/CategoryTest', [
            'categoryTests' => $categoryTests
        ]);
    }
}
