<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class PasswordController extends Controller
{
    public function show()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                                'required',
                                'confirmed',
                                Password::min(8)
                                    ->mixedCase() // majuscule + minuscule
                                    ->letters() // au moins une lettre
                                    ->numbers() // au moins un chiffre
                                    ->symbols() // au moins un symbole
                                    ->uncompromised() // vérifie si le mot de passe a déjà fuité (sécurité ++)
                            ],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Le mot de passe actuel est incorrect.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'must_change_password' => false
        ]);

        return redirect()->route('admin.believers.statistics')->with('success', 'Votre mot de passe a été changé avec succès.');
    }
}
