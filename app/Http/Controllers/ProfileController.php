<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // 1. Tampilkan Halaman Profile
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

 public function update(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'name'          => 'required|string|max:255',
        'npm'           => 'nullable|string|max:20',
        'no_hp'         => 'nullable|string|max:15',
        'tanggal_lahir' => 'nullable|date',
        'prodi'         => 'nullable|string|in:TI,RPL,RSK,ILKOM',
        'semester'      => 'nullable|integer|min:1|max:14',
    ]);

    $user->update($validated);

    return redirect()->back()->with('success', 'Informasi profil berhasil diperbarui!');
}
   public function updateProfilePhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user = auth()->user();

    if ($request->hasFile('photo')) {
        // Hapus foto lama jika ada
        if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        // Simpan file ke folder 'profile_photos'
        $path = $request->file('photo')->store('profile_photos', 'public');


        $user->update([
            'foto_profil' => $path
        ]);
    }

    return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
}

}