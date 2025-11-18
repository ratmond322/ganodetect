<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Socialite; // use Laravel\Socialite\Facades\Socialite; or alias Socialite in top of file
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
        // jika error CSRF/state di local, ganti ke ->stateless()->redirect();
    }

    // Handle callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // jika provider tidak mengembalikan email, kamu harus handle
            $email = $googleUser->getEmail();
            if (!$email) {
                return redirect()->route('login')->withErrors(['google' => 'Google account has no email.']);
            }

            // cari user berdasarkan provider_id dulu, lalu email
            $user = User::where('provider', 'google')
                        ->where('provider_id', $googleUser->getId())
                        ->first();

            if (! $user) {
                // jika sudah ada pengguna dengan email sama (register manual), link akun
                $user = User::where('email', $email)->first();
            }

            if (! $user) {
                // buat user baru
                $user = User::create([
                    'name' => $googleUser->getName() ?? $email,
                    'email' => $email,
                    // buat password random, user login via google biasanya tidak pakai password
                    'password' => bcrypt(Str::random(32)),
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            } else {
                // update provider info kalau belum ada
                $user->update([
                    'provider' => 'google',
                    'provider_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar() ?? $user->avatar,
                ]);
            }

            Auth::login($user, true);
            return redirect()->intended('/');
        } catch (\Exception $e) {
            // debug: simpan error message ke log
            \Log::error('Google auth callback error: '.$e->getMessage());
            return redirect()->route('login')->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }
}
