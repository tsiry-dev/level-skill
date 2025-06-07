<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SecurityController extends Controller
{
    public function index()
    {
        return inertia('admin/security/Security');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // ✅ Validation des données envoyées depuis Vue
        $validated = $request->validate([
            'old_password' => ['required'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'old_password.required' => 'Veuillez entrer votre mot de passe actuel.',
            'password.required' => 'Veuillez entrer un nouveau mot de passe.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if (!Hash::check($validated['old_password'], $user->password)) {
            return back()->withErrors([
                'old_password' => 'Votre ancien mot de passe est incorrecte'
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

         Auth::logout();

         return redirect()->route('login')->with('success', 'Mot de passe modifié. Veuillez vous reconnecter.');
    }
}
