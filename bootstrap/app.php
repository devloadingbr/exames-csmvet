<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'tenant' => App\Http\Middleware\TenantMiddleware::class,
            'role' => App\Http\Middleware\RoleMiddleware::class,
        ]);
        
        // Handle authentication redirects
        $middleware->redirectGuestsTo(function ($request) {
            if ($request->routeIs('admin.*') || $request->is('admin*')) {
                return route('admin.login');
            }
            
            if ($request->routeIs('superadmin.*') || $request->is('superadmin*')) {
                return route('superadmin.login');
            }
            
            if ($request->routeIs('client.*') || $request->is('client*')) {
                return route('client.login');
            }
            
            // Default fallback
            return route('landing');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AuthenticationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            if ($request->routeIs('admin.*') || $request->is('admin*')) {
                return redirect()->guest(route('admin.login'));
            }
            
            if ($request->routeIs('superadmin.*') || $request->is('superadmin*')) {
                return redirect()->guest(route('superadmin.login'));
            }
            
            if ($request->routeIs('client.*') || $request->is('client*')) {
                return redirect()->guest(route('client.login'));
            }

            return redirect()->guest(route('landing'));
        });
    })->create();
