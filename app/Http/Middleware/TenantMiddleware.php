<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // SuperAdmin tem acesso total
        if (auth()->check() && auth()->user()->role === 'superadmin') {
            return $next($request);
        }

        // Para outros usuários, verificar se têm clínica
        if (auth()->check()) {
            $clinicId = auth()->user()->clinic_id;

            if (!$clinicId) {
                abort(403, 'Acesso negado: usuário sem clínica associada');
            }

            // Definir tenant global para queries
            app()->instance('current_clinic_id', $clinicId);

            return $next($request);
        }

        // Se não estiver logado, prosseguir normalmente
        return $next($request);
    }
}