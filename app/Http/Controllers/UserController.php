<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): View
    {
        $store = Auth::user()->store;
        $users = User::where('store_id', $store->id)->orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function invite(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:admin,manager,cashier',
        ]);

        $store = Auth::user()->store;
        $temp  = Str::random(12);

        $user = User::create([
            'name'     => 'Invited user',
            'email'    => $request->email,
            'password' => Hash::make($temp),
            'role'     => $request->role,
            'status'   => 'pending',
            'store_id' => $store->id,
        ]);

        ActivityLog::record($store->id, 'system', "Invite sent to {$request->email} as {$request->role}");

        // TODO: send actual invite email with $temp password or magic link
        return back()->with('success', "Invite sent to {$request->email}.");
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        abort_if($user->store_id !== Auth::user()->store_id, 403);
        abort_if($user->role === 'owner', 403, 'Cannot change the owner role.');
        $request->validate(['role' => 'required|in:admin,manager,cashier']);
        $user->update(['role' => $request->role]);
        return back()->with('success', "{$user->name}'s role updated.");
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->store_id !== Auth::user()->store_id, 403);
        abort_if($user->id === Auth::id(), 403, 'Cannot remove yourself.');
        abort_if($user->role === 'owner', 403, 'Cannot remove the store owner.');
        $name = $user->name;
        $user->delete();
        ActivityLog::record(Auth::user()->store_id, 'system', "Team member removed: {$name}");
        return back()->with('success', "{$name} removed from the team.");
    }
}
