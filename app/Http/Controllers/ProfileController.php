<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(): View
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'bio' => ['nullable', 'string', 'max:1000'],
                'weight' => ['nullable', 'numeric', 'min:20', 'max:500'],
                'height' => ['nullable', 'numeric', 'min:100', 'max:250'],
                'date_of_birth' => ['nullable', 'date', 'before:today'],
                'gender' => ['nullable', 'string', 'in:male,female,other,prefer_not_to_say'],
                'profile_photo' => ['nullable', 'image', 'max:1024'],
            ]);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                // Delete old photo if exists
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Store new photo
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $validated['profile_photo_path'] = $path;
            }

            $user->update($validated);

            return redirect()->route('profile.show')
                ->with('success', 'Profile updated successfully.');
        } catch(\Exception $e) {
            \Log::error("Error updating profile: ", $e->getMessage());
            return back()->withErrors("error", "Error updating profile");
        }
    }

    /**
     * Show the form for changing the user's password.
     */
    public function editPassword()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Remove the profile photo.
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->update(['profile_photo_path' => null]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profile photo removed.');
    }
}
