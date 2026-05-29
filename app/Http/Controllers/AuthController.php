<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // public function showRegister(): View { return view('auth.register'); }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ]);
    }

    public function showlogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // Create store first
        $store = Store::create([
            'code'          => 'STORE-' . strtoupper(Str::random(5)),
            'city'          => $validated['store_city'] ?? null,
            'province'      => $validated['store_province'] ?? null,
            'plan'          => $validated['plan'] ?? 'free',
            'trial_ends_at' => now()->addDays(60),
        ]);

        // Create owner user
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'] ?? 'owner',
            'status'   => 'active',
            'store_id' => $store->id,
        ]);

        // Link user to store
        $store->update(['user_id' => $user->id, 'store_name' => $validated['store_name']]);

        // Record activity
        ActivityLog::create([
            'store_id' => $store->id,
            'user_id' => $user->id,
            'type' => 'system',
            'description' => 'Store created · ' . $store->store_name,
        ]);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        // Log in the user
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registration successful! Please verify your email.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard');
    }
}
