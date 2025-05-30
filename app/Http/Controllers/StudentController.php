<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
public function index(Request $request)
{
    $searchTerm = $request->input('search', '');

    $query = User::where('role', '=', 'user');

    if ($searchTerm) {
        $query->where(function($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('email', 'like', '%' . $searchTerm . '%');
        });
    }

    $students = $query
        ->withCount('submissions')
        ->orderBy('submissions_count', 'desc')
        ->paginate(10)
        ->withQueryString();

    $students->load('submissions.activityType');

    return inertia('admin/students/Student', [
        'students' => $students,
    ]);
}


    public function show(User $user)
    {

        $user->load('submissions.activityType');

         return inertia('admin/students/StudentShow', [
              'student' => $user
         ]);
    }
}
