<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Formateur;
use App\Models\Niveau;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {


        return Inertia::render('auth/Register', [
            'formateurs' => Formateur::all(),
            'niveaux' => Niveau::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'formateur_id' => 'required|exists:formateurs,id',
            'niveau_id' => 'required|exists:niveaux,id',
        ]);


        $user = User::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-'. time() . mt_rand(145, 89521),
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'niveau_id' => $request->niveau_id,
            'formateur_id' => $request->formateur_id,
            'remember_token' => Str::random(10),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return to_route('dashboard');
    }
}
