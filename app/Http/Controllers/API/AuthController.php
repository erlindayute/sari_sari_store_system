<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    // public function showRegister(): View { return view('auth.register'); }
    public function register(RegisterRequest $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            'store_name' => 'required|string|max:200',
            'city'       => 'nullable|string|max:100',
            'province'   => 'nullable|string|max:100',
            'plan'       => 'nullable|in:free,pro,business',
            'terms'      => 'accepted',
        ]);

        // Create store first
        $store = Store::create([
            'name'          => $data['store_name'],
            'code'          => 'STORE-' . strtoupper(Str::random(5)),
            'city'          => $data['city'] ?? null,
            'province'      => $data['province'] ?? null,
            'plan'          => $data['plan'] ?? 'pro',
            'trial_ends_at' => now()->addDays(60),
        ]);

        // Create owner user
        $user = User::create([
            'name'     => $data['first_name'] . ' ' . $data['last_name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'owner',
            'status'   => 'active',
            'store_id' => $store->id,
        ]);

        $store->update(['owner_id' => $user->id]);
        ActivityLog::record($store->id, 'system', 'Store created · ' . $store->name, $user->id);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('onboarding', true);
    }


    /* ── Login ── */
    //public function showLogin(): View { return view('auth.login'); }
    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $user = Auth::user();
        if ($user->status === 'suspended') {
            Auth::logout();
            return back()->withErrors(['email' => 'Your account has been suspended. Contact the store owner.']);
        }

        // $user->update(['last_login_at' => now()]);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
    /* ── Forgot password ── */
    // public function showForgot(): View { return view('auth.forgot'); }

    //  public function sendResetLink(Request $request): RedirectResponse
    //{
    //  $request->validate(['email' => 'required|email']);
    //Password::sendResetLink($request->only('email'));
    // Always return success to prevent email enumeration
    //return back()->with('status', 'If that email is registered, a reset link has been sent.');
    // }

    //public function showReset(string $token): View
    //{
    //  return view('auth.reset', ['token' => $token]);
    //}

    //public function resetPassword(Request $request): RedirectResponse
    //{
    //  $request->validate([
    //    'token'                 => 'required',
    //  'email'                 => 'required|email',
    // 'password'              => 'required|min:8|confirmed',
    //]);

    //$status = Password::reset(
    //  $request->only('email','password','password_confirmation','token'),
    //  function (User $user, string $password) {
    //     $user->forceFill(['password' => Hash::make($password)])->save();
    //}
    //);

    //return $status === Password::PASSWORD_RESET
    //   ? redirect()->route('login')->with('success', 'Password reset successfully.')
    //  : back()->withErrors(['email' => __($status)]);
    //}
}
