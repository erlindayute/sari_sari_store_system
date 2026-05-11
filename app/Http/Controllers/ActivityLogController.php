<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ActivityLogController extends Controller
{
    public function updateAccount(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Verify current password
        if (!empty($data['current_password'])) {

            if (!Hash::check($data['current_password'], $user->password)) {

                return back()->withErrors([
                    'current_password' => 'Current password is incorrect.'
                ]);
            }
        }

        // Prepare updates
        $updates = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ];

        // Update password if provided
        if (!empty($data['password'])) {
            $updates['password'] = Hash::make($data['password']);
        }

        // Save user
        //$user->update($updates);

        // Record activity log
        ActivityLog::record(
            $user->id,
            'system',
            'Account settings updated'
        );

        return back()->with('success', 'Account settings saved.');
    }
}
