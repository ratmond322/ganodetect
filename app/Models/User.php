<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',

        // social/login fields
        'provider',
        'provider_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Helper accessor: return a usable avatar URL.
     * - If user has profile_photo (uploaded), return it from storage.
     * - If user has provider avatar (full URL from Google), return it.
     * - Otherwise return a default avatar image.
     *
     * Usage in Blade: <img src="{{ $user->avatar_url }}" alt="avatar">
     *
     * @return string
     */
    public function getAvatarUrlAttribute()
    {
        // jika ada profile_photo yang diupload, prioritaskan ini
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        // jika sudah full URL (Google), kembalikan langsung
        if ($this->avatar && (str_starts_with($this->avatar, 'http') || str_starts_with($this->avatar, '//'))) {
            return $this->avatar;
        }

        // jika avatar disimpan sebagai filename di public/images/
        if ($this->avatar) {
            return asset('images/' . ltrim($this->avatar, '/'));
        }

        // fallback default avatar
        return asset('images/avatar.jpg');
    }
}
