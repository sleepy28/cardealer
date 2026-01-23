<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ], [
            
            'avatar.max' => '⚠️ Ukuran foto terlalu besar. Mohon unggah file di bawah 2MB.',
            'avatar.image' => '⚠️ File yang diunggah harus berupa gambar.',
            'avatar.mimes' => '⚠️ Format tidak didukung. Harap gunakan JPG, JPEG, atau PNG.',
            'username.unique' => '⚠️ Username ini sudah digunakan oleh karyawan lain.',
        ]);

        
        if ($request->hasFile('avatar')) {
            
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            
            $path = $request->file('avatar')->store('avatars', 'public');
            
            
            $user->update(['avatar' => $path]);
        }

     
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
        ]);

    
        if ($request->filled('current_password') || $request->filled('new_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'min:8', 'confirmed'],
            ], [
                'current_password.current_password' => '⚠️ Password saat ini salah. Verifikasi gagal.',
                'new_password.confirmed' => '⚠️ Konfirmasi password baru tidak cocok.',
                'new_password.min' => '⚠️ Password baru minimal 8 karakter.',
            ]);

            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}