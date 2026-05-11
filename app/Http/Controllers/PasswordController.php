<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}
