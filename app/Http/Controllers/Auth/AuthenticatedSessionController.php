<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirección inteligente según el rol del usuario
        $user = $request->user();

        if ($user->rol_id === 1) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->rol_id === 2) {
            return redirect()->intended(route('medico.pacientes.index'));
        }

        if ($user->rol_id === 3) {
            return redirect()->intended(route('paciente.dashboard'));
        }

        // Fallback: si no tiene rol reconocido, va al login
        return redirect()->route('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}