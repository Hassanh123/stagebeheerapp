<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Toon loginpagina
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Verwerk login (student / teacher)
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();

            // ✅ Zowel studenten als docenten gaan naar 'home'
            if (in_array($user->role, ['student', 'teacher'])) {
                return redirect()->route('home');
            }

            // Admins mogen hier niet inloggen
            Auth::guard('web')->logout();
            return back()->withErrors([
                'email' => 'Admins loggen in via /admin',
            ]);
        }

        return back()->withErrors([
            'email' => 'Ongeldige inloggegevens.',
        ]);
    }

    /**
     * Uitloggen via POST
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ✅ Na uitloggen netjes naar homepagina
        return redirect('/');
    }
}
