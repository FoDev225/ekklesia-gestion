<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AutoLogout
{
    // Temps max d'inactivité en secondes (ex: 15 minutes = 900 secondes)
    protected int $timeout = 900;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            $lastActivity = session('last_activity');

            $currentTime = time();

            if ($lastActivity && ($currentTime - $lastActivity) > $this->timeout) {
                
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                session()->flush();
                return redirect()->route('login')->withErrors(['session' => 'Votre session a expiré par inactivité. Veuillez vous reconnecter.']);
            }

            // Mise à jour de la dernière activité
            session(['last_activity' => $currentTime]);
        }
        
        return $next($request);
    }
}
