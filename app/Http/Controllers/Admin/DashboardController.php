<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\CategoryTest;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

       $categoryTest = CategoryTest::all();
       $categoryTest->load('activities');

        return inertia('admin/Dashboard', [
            'categories' => $categoryTest,
            'submissions' => Submission::all()
        ]);
    }
}
