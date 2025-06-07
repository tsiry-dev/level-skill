<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use App\Models\Formateur;
use App\Models\Niveau;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index(Request $request)
    {

        // 📝Student with nb submissions
        $students = User::filter()
            ->withCount('submissions')
            ->orderBy('submissions_count', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Charging relationships
        $students->load([
            'submissions.activityType',
            'formateur',
            'niveau'
        ]);

        return inertia('admin/students/Student', [
            'students' => $students,
            'formateurs' => Formateur::all(),
            'niveaux' => Niveau::all(),
        ]);
    }

    public function show(User $user)
    {

         $user->load(
            'submissions.activityType',
            'formateur',
            'niveau'
         );

         $submissions = Submission::where('user_id', $user->id)->get();
         $submissions->load([
            'activityType.activity',
         ]);


         return inertia('admin/students/StudentShow', [
              'student' => $user,
              'activityTypes' => ActivityType::all(),
              'submissions' => $submissions
         ]);
    }
}
