<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register'); // make sure this view exists
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'userType' => ['required', 'in:super_admin,owner,tenant,agent'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()], // 'confirmed' expects 'password_confirmation'
            'access_code' => ['nullable', 'required_if:userType,super_admin', 'string', 'max:255'],
        ]);

        // Determine role
        $role = $request->userType;
        $accessCode = $request->access_code;
        $secretCode = env('SUPER_ADMIN_ACCESS_CODE', 'default_secret');

        // Only allow super_admin if selected and code matches
        if ($request->userType === 'super_admin' && $accessCode && $accessCode === $secretCode) {
            $role = 'super_admin';
        } elseif ($request->userType === 'super_admin') {
            // This shouldn't reach here due to validation, but safety
            throw \Illuminate\Validation\ValidationException::withMessages([
                'access_code' => ['Invalid access code for Super Admin.'],
            ]);
        }

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        event(new Registered($user));

        // Redirect to login with success message instead of logging in
        return redirect()->route('login')->with('success', 'Registration successful! Please log in with your new account.');
    }
}