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

        $remember = $request->has('remember');

        if (!Auth::attempt($credentials, $remember)) {

            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
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
        $request->validated([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'store_name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'plan' => 'nullable|string|max:255',
        ]);

        // Create store first
        $store = Store::create([
            'code'          => 'STORE-' . strtoupper(Str::random(5)),
            'city'          => $request->city ?? null,
            'province'      => $request->province ?? null,
            'plan'          => $request->plan ?? 'free',
            'trial_ends_at' => now()->addDays(60),
        ]);

        // Create owner user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => $request->email,
            'phone'    => $request->phone ?? null,
            'password' => Hash::make($request->password),
            'role'     => 'owner',
            'status'   => 'active',
            'store_id' => $store->id,
        ]);

        // Create Store

        $Store = Store::create([
            'user_id' => $user->id,
            'store_name' => $request->store_name,
            'code' => 'STORE-' . strtoupper(Str::random(5)),
            'city' => $request->city ?? null,
            'province' => $request->province ?? null,
            'plan' => $request->plan ?? 'free',
            'trial_ends_at' => now()->addDays(60),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('onboarding', true);


        $store->update(['owner_id' => $user->id]);
        ActivityLog::record($store->id, 'system', 'Store created · ' . $store->name, $user->id);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('onboarding', true);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('dashboard.home');
    }
}
