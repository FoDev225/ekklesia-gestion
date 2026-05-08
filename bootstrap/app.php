<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ForcePasswordChange;
use App\Http\Middleware\EnsureUserIsActive;
use App\Http\Middleware\AutoLogout;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        //api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
                'force.password.change' => ForcePasswordChange::class,
                'ensure.user.active' => EnsureUserIsActive::class,
                'auto.logout' => AutoLogout::class,
                'role' => App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException $e, Request $request) {
            if ($request->routeIs('auth_login')) {
                
                $seconds = (int) ($e->getHeaders()['Retry-After'] ?? 180);
                
                return redirect()
                    ->back()
                    ->withInput($request->only('username'))
                    ->withErrors([
                    'throttle' => "Trop de tentatives de connexion."])
                    ->with('retry_after', $seconds);
            }
        });
    })->create();
