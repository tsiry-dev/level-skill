<?php

namespace App\Http\Controllers;

use App\Models\Formateur;
use App\Models\Niveau;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->input('search', '');
        $byFormateur = $request->input('byFormateur', '');
        $byNiveau = $request->input('byNiveau', '');

        $query = User::where('role', '=', 'user');

        // 🔍 Recherche par nom ou email
        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        // 🧑‍🏫 Filtre par formateur (via slug)
        if ($byFormateur) {
            $query->whereHas('formateur', function ($q) use ($byFormateur) {
                $q->where('slug', $byFormateur);
            });
        }

        // 🎓 Filtre par niveau (via slug)
        if ($byNiveau) {
            $query->whereHas('niveau', function ($q) use ($byNiveau) {
                $q->where('slug', $byNiveau);
            });
        }

        // 📝 Récupération des étudiants avec leur nombre de submissions
        $students = $query
            ->withCount('submissions')
            ->orderBy('submissions_count', 'desc')
            ->paginate(10)
            ->withQueryString(); // ← conserve les filtres dans les liens de pagination

        // Chargement des relations nécessaires
        $students->load('submissions.activityType', 'formateur', 'niveau');

        return inertia('admin/students/Student', [
            'students' => $students,
            'formateurs' => Formateur::all(),
            'niveaux' => Niveau::all(),
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
