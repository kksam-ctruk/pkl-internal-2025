<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest; // Dia Ambil data yang sudah di Validasi dari Form
use Illuminate\Http\RedirectResponse; 
use Illuminate\Http\Request;            //Ini Request biasa 
use Illuminate\Support\Facades\Auth;   //Logout User ✔️
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


class ProfileController extends Controller
{

    public function edit(Request $request): View // Menampilkan form edit Profile
    {
        return view('profile.edit', [
            'user' => $request->user(), //Ambil data dari User yang sedang Login
        ]);
    }






public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    $user->fill(
        $request->safe()->except('avatar')
    );

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return back()->with('success', 'Profil berhasil diperbarui!');
}
            







    protected function uploadAvatar(Request $request, $user): string
{
    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
        Storage::disk('public')->delete($user->avatar);
    }

    $filename = 'avatar-' . $user->id . '-' . time() . '.' . $request->file('avatar')->extension();

    return $request->file('avatar')->storeAs(
        'avatars',
        $filename,
        'public'
    );
}






    public function deleteAvatar(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar); // Hapus Avatar
            $user->update(['avatar' => null]);  // jika avatar tidak ada set NULL
        }
        return back()->with('success', 'Foto profil berhasil dihapus.');
    }





    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        $request->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']), //Sajikan Valiadsi ulang
        ]);
        return back()->with('status', 'password-updated'); //Update ketika selesai
    }








    public function destroy(Request $request): RedirectResponse //Hapus akun dan semua nya
    { 
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'], //Pastikan dia beneran user minta password
        ]);
        $user = $request->user();
        Auth::logout();  //Logout User

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);  //Hapus avatar tersedia
        }

        $user->delete(); // HAPUS!
        $request->session()->invalidate();  // Invalidasi
        $request->session()->regenerateToken();  // Buat Ulang Token Login
        return Redirect::to('/'); // Kembalikan ke entry Lobby
    }


    public function updateAvatar(Request $request): RedirectResponse
        {
            $request->validate([
                'avatar' => [
                    'required',
                    'image',
                    'mimes:jpeg,jpg,png,webp',
                    'max:2048',
                ],
            ]);

            $user = $request->user();

            $avatarPath = $this->uploadAvatar($request, $user);
            $user->update(['avatar' => $avatarPath]);

            return back()->with('success', 'Foto profil berhasil diperbarui.');
        }


        public function unlinkGoogle(Request $request): RedirectResponse
            {
                $user = $request->user();

                $user->google_id = null;
                $user->save();

                return back()->with('success', 'Koneksi dengan Google berhasil diputus.');
            }


}