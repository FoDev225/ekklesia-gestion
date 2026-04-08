<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.menu.dashboard');
        }

        return view('auth.login');
    }

    public function auth_login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        // Utilisateur inexistant
        if (!$user) {
            $this->logLogin($request, null, false);
            return back()->withErrors(['username' => 'Le nom utilisateur fourni est incorrect.'])->onlyInput('username');
        }

        // Compte désactivé
        if (!$user->is_active) {
            $this->logLogin($request, $user->id, false);
            return back()->withErrors(['username' => 'Ce compte est désactivé. Veuillez contacter l\'administrateur.'])->onlyInput('username');
        }

        // Tentative de connexion
        if (!Auth::attempt($request->only('username', 'password'))) {
            $this->logLogin($request, $user->id, false);
            return back()->withErrors(['password' => 'Le mot de passe saisi est incorrect.'])->onlyInput('username');
        }

        // Connexion réussie
        $request->session()->regenerate();
        RateLimiter::clear($request->input('username').$request->ip());
        $this->logLogin($request, $user->id, true);

        // Forcer changement de mot de passe pour la première connexion
        if ($user->must_change_password) {
            return redirect()->route('password.change')->with('error', 'Veuillez changer le mot de passe par défaut avant de continuer.');
        }

        // Redirect to intended route or dashboard
        return redirect()->route('admin.menu.dashboard');
    }

    private function logLogin(Request $request, $userId, bool $success)
    {
        LoginHistory::create([
            'user_id' => $userId,
            'ip_address' => (string) $request->ip(),
            'user_agent' => substr($request->userAgent(), 0, 5000),
            'logged_in_at' => now(),
            'successful' => $success,
        ]);
    }


    public function logout(Request $request)
    {
        $history = LoginHistory::where('user_id', Auth::id())
            ->whereNull('logged_out_at')
            ->latest()
            ->first();

        if ($history) {
            $history->update(['logged_out_at' => now()]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous êtes déconnecté avec succès.');
    }
}
