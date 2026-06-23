<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Update the user's password after verifying current password
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validate the password inputs
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
        ]);

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        // Prevent using the same password
        if (Hash::check($validated['new_password'], $user->password)) {
            return back()->withErrors([
                'new_password' => 'New password cannot be the same as current password.',
            ]);
        }

        // Update the password
        // $user->update([
        //   'password' => Hash::make($validated['new_password']),
        //]);

        return back()->with('success', 'Password updated successfully.');
    }

    // ─────────────────────────────────────────────────────────
    // STEP 1 — Show the "Forgot password" form
    // GET /forgot-password  →  named: password.request
    // ─────────────────────────────────────────────────────────
    public function showForgot(): View
    {
        return view('auth.forgot');
    }

    // ─────────────────────────────────────────────────────────
    // STEP 2 — Handle the email submission
    // POST /forgot-password  →  named: password.email
    // ─────────────────────────────────────────────────────────
    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Laravel's built-in broker sends the reset email.
        // We ALWAYS return the same success message to prevent
        // email enumeration attacks (don't tell the user if
        // the email exists or not).
        Password::sendResetLink(
            $request->only('email')
        );

        return back()->with(
            'status',
            __('If that email address is registered, we\'ve sent a password reset link.')
        );
    }

    // ─────────────────────────────────────────────────────────
    // STEP 3 — Show the "Set new password" form
    // GET /reset-password/{token}  →  named: password.reset
    // ─────────────────────────────────────────────────────────
    public function showReset(string $token): View
    {
        return view('auth.reset', [
            'token' => $token,
            'email' => request()->query('email', ''),
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // STEP 4 — Handle the new password submission
    // POST /reset-password  →  named: password.update
    // ─────────────────────────────────────────────────────────
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token'                 => ['required'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Optional: fire PasswordReset event
                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()
            ->route('login')
            ->with('success', '✓ Password reset successfully. Please sign in.')
            : back()
            ->withErrors(['email' => __($status)])
            ->withInput($request->only('email'));
    }
}
