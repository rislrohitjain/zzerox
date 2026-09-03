<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'designation' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'whatsapp' => 'nullable|string|max:50',
            'linkedin' => 'nullable|url|max:255',
            'twitter' => 'nullable|string|max:255',
            'telegram' => 'nullable|string|max:100',
            'facebook' => 'nullable|url|max:255',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        // Handle Avatar Photo Upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('img/avatars'), $fileName);
            $validated['avatar'] = 'img/avatars/' . $fileName;
        }

        // Handle Password Change if requested
        if ($request->filled('new_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->back()->withErrors(['current_password' => 'Current password entered is incorrect.']);
            }
            $validated['password'] = Hash::make($request->input('new_password'));
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'Your Admin Profile, Avatar Photo, Mobile & Social details have been updated successfully!');
    }
}
