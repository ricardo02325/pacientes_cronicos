<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica que el usuario autenticado tenga uno de los roles permitidos.
     *
     * Uso en rutas: ->middleware('role:1')       → solo admin
     *               ->middleware('role:1,2')     → admin y médico
     *               ->middleware('role:3')       → solo paciente
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array((string) $user->rol_id, $roles)) {
            // Redirigir al dashboard correspondiente o al login
            if (!$user) {
                return redirect()->route('login');
            }

            // Redirigir según su rol real
            return match ((int) $user->rol_id) {
                1 => redirect()->route('admin.dashboard'),
                2 => redirect()->route('medico.pacientes.index'),
                3 => redirect()->route('paciente.dashboard'),
                default => redirect()->route('login'),
            };
        }

        return $next($request);
    }
}
