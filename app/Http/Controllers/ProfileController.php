<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ];

        // Tambahkan validasi password hanya jika ada input password
        if ($request->filled('current_password') || $request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'confirmed', 'min:8'];
        }

        $validated = $request->validate($rules);

        try {
            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                Log::info('Uploading profile photo', [
                    'original_name' => $request->file('profile_photo')->getClientOriginalName(),
                    'size' => $request->file('profile_photo')->getSize(),
                    'mime_type' => $request->file('profile_photo')->getMimeType()
                ]);

                // Delete old photo if exists
                if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                    Log::info('Deleting old profile photo', ['path' => $user->profile_photo_path]);
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                // Store new photo
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                Log::info('New profile photo stored', ['path' => $path]);
                
                if ($path) {
                    $user->profile_photo_path = $path;
                    Log::info('Profile photo path updated in user model');
                } else {
                    Log::error('Failed to store profile photo');
                    throw new \Exception('Gagal menyimpan foto profil');
                }
            }

            // Update user information
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];

            // Update password if provided
            if (isset($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();
            Log::info('User profile updated successfully', ['user_id' => $user->id]);

            return back()->with('success', 'Profil berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating profile', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // If there was an error and we uploaded a new photo, delete it
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui profil: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete profile photo if exists
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function index(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }
} 