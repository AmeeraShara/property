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

        // Get the authenticated user
        $user = Auth::user();

        // Redirect based on user role
        return $this->redirectToDashboard($user);
    }

    /**
     * Redirect user to appropriate dashboard based on role
     */
    private function redirectToDashboard($user): RedirectResponse
    {
        $route = match($user->role) {
            'super_admin' => 'dashboard.index',
            'agent' => 'dashboard.index',  // Fallback; add 'agent.dashboard' route if needed
            'owner' => 'dashboard.index',  // Matches your registration roles
            'landlord' => 'dashboard.index',  // Fallback; adjust as needed
            default => 'dashboard.index',
        };

        return redirect()->intended(route($route, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
{
    // Temp: Log to verify POST arrives
    \Illuminate\Support\Facades\Log::info('Logout POST hit - User ID: ' . Auth::id() . ' | Redirecting to login');

    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('status', 'You have been logged out successfully.');
}
}