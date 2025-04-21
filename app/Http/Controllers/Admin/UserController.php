<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();

        if($request->has('search')) {
            $search = $request->serach;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}")->orWhere('email', 'like', "%{$search}");
            });
        }

        if ($request->has('status') && in_array($request->status, ['active', 'banned'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user)
    {
        if($user->id === auth()->id()) {
            return back()->withErrors("error","You can't bann yourself");
        }

        $user->update([
            'status' => "banned",
            "banned_at" => now()
        ]);

        return back()->with("success", "User {$user->name} has been banned");
    }

    public function reactiveUser(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->update([
            'status' => 'active',
            'banned_at' => null
        ]);

        return back()->with('success', "User {$user->name} has been reactivated.");
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'status' => ['required', Rule::in(['active', 'banned'])],
        ]);

        if ($user->id === auth()->id() && $user->status !== $validated['status']) {
            return back()->with('error', 'You cannot change your own status.');
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been updated.");
    }

    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }

        $user->delete();
        return back()->withErrors("success", "User deleted successfully");
    }
}
