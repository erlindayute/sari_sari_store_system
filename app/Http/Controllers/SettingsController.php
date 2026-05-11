<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('settings.index', [
            'user'  => Auth::user() ?? null,
            'store' => Auth::user()->store ?? null,
        ]);
    }

    public function updateStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'                 => 'required|string|max:200',
            'city'                 => 'nullable|string|max:100',
            'province'             => 'nullable|string|max:100',
            'currency'             => 'required|string|max:10',
            'timezone'             => 'required|string',
            'low_stock_threshold'  => 'required|integer|min:5|max:50',
        ]);

        $store = Auth::user()->store ?? null;
        if ($store) {
            $store->update($data);
            ActivityLog::record(Auth::id(), 'system', 'Store settings updated');
        }

        return back()->with('success', 'Store settings saved.');
    }

    public function updateAccount(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'email'             => 'required|email|unique:users,email,' . $user->id,
            'phone'             => 'nullable|string|max:20',
            'current_password'  => 'nullable|required_with:password',
            'password'          => 'nullable|min:8|confirmed',
        ]);

        if (!empty($data['current_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
        }

        // $updates = ['name' => $data['name'], 'email' => $data['email'], 'phone' => $data['phone'] ?? null];
        //if (!empty($data['password'])) $updates['password'] = Hash::make($data['password']);
        //$user->update($updates);

        ActivityLog::record(Auth::id(), 'system', 'Account settings updated');

        return back()->with('success', 'Account settings saved.');
    }
}
