<?php
// ========================================
// FILE: app/Http/Controllers/Auth/GoogleController.php
// FUNGSI: Menghandle proses login dengan Google OAuth
// ========================================

namespace App\Http\Controllers\Auth;
// ↑ Namespace adalah "alamat" file dalam struktur folder
// File ini berada di app/Http/Controllers/Auth/

use App\Http\Controllers\Controller;   // Base controller
use App\Models\User;                   // Model User untuk interaksi database
use Illuminate\Support\Facades\Auth;   // Facade untuk authentication
use Illuminate\Support\Facades\Hash;   // Facade untuk hashing password
use Illuminate\Support\Str;            // Helper untuk string manipulation
use Laravel\Socialite\Facades\Socialite; // ⭐ Package Socialite untuk OAuth
use Exception;                         // Class untuk handle error

class GoogleController extends Controller
{
    /**
     * Redirect user ke halaman OAuth Google.
     *
     * Method ini dipanggil ketika user klik tombol "Login dengan Google".
     * Socialite akan membangun URL lengkap dengan semua parameter OAuth.
     *
     * Route: GET /auth/google
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // ================================================
        // MEMBANGUN URL REDIRECT KE GOOGLE
        // ================================================
        // ⚠️ FIX KEAMANAN PENTING:
        // 'prompt' => 'select_account'
        // - MENCEGAH silent login setelah logout
        // - MEMAKSA Google selalu menampilkan pilihan akun
        // - AMAN untuk komputer bersama
        // ================================================

        return Socialite::driver('google')
            // ->stateless() // Opsional: Gunakan jika error "InvalidStateException" terus muncul
            ->scopes(['email', 'profile' ,'openid'])
            // ↑ Scopes menentukan data apa yang kita minta
            // 'email'   = Alamat email user
            // 'profile' = Nama dan foto profil
            // 'openid'  = Otomatis ditambahkan untuk Google
            ->with([
                'prompt' => 'select_account',
                // ↑ INI KUNCI UTAMA PERMASALAHAN KAMU
                // Tanpa ini → Google boleh auto-login
                // Dengan ini → Google WAJIB minta pilih akun
            ])
            ->redirect();
            // ↑ Redirect ke Google OAuth endpoint
    }

    /**
     * Handle callback dari Google setelah user memberikan izin.
     *
     * Method ini dipanggil oleh Google setelah user klik "Allow".
     * Google akan mengirimkan authorization_code ke URL ini.
     *
     * Route: GET /auth/google/callback
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        // ================================================
        // CEK JIKA USER MEMBATALKAN LOGIN
        // ================================================

        if (request()->has('error')) {
            $error = request('error');

            if ($error === 'access_denied') {
                return redirect()
                    ->route('login')
                    ->with('info', 'Login dengan Google dibatalkan.');
            }

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan: ' . $error);
        }

        // ================================================
        // PROSES OAUTH
        // ================================================

        try {
            $googleUser = Socialite::driver('google')->user();
            // ↑ Ambil data user dari Google (setelah OAuth sukses)

            // ================================================
            // CARI ATAU BUAT USER DI DATABASE
            // ================================================
            $user = $this->findOrCreateUser($googleUser);

            // ================================================
            // LOGIN USER KE APLIKASI
            // ================================================
            // ⚠️ KEAMANAN:
            // Jangan pakai remember:true secara paksa
            // Agar login tidak "lengket" di komputer umum
            Auth::login($user);

            // ================================================
            // REGENERATE SESSION (ANTI SESSION FIXATION)
            // ================================================
            session()->regenerate();

            // ================================================
            // REDIRECT KE HALAMAN TUJUAN
            // ================================================
            return redirect()
                ->intended(route('home'))
                ->with('success', 'Berhasil login dengan Google!');

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {

            return redirect()
                ->route('login')
                ->with('error', 'Session telah berakhir. Silakan coba lagi.');

        } catch (\GuzzleHttp\Exception\ClientException $e) {

            logger()->error('Google API Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Terjadi kesalahan saat menghubungi Google.');

        } catch (Exception $e) {

            logger()->error('OAuth Error: ' . $e->getMessage());

            return redirect()
                ->route('login')
                ->with('error', 'Gagal login. Silakan coba lagi.');
        }
    }

    /**
     * Cari user berdasarkan Google ID atau email, atau buat user baru.
     */
    protected function findOrCreateUser($googleUser): User
    {
        // ================================================
        // SKENARIO 1: SUDAH PERNAH LOGIN GOOGLE
        // ================================================
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            if ($user->avatar !== $googleUser->getAvatar()) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
            return $user;
        }

        // ================================================
        // SKENARIO 2: USER REGISTER MANUAL (EMAIL SAMA)
        // ================================================
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar() ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ]);
            return $user;
        }

        // ================================================
        // SKENARIO 3: USER BARU
        // ================================================
        return User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(24)),
            'role' => 'customer',
        ]);
    }
}
