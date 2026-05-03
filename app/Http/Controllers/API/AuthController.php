<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('login')->with('success', 'Registration successful! Please sign in with your credentials.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'An error occurred during registration. Please try again.',
            ])->withInput($request->only('name', 'email'));
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->withInput($request->only('email'));
        }

        $user = Auth::user();

        if (!$user || !$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account has been deactivated.',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Login successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }

    private function userResource(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
