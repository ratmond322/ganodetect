<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'is_used',
        'used_by_user_id',
    ];

    protected $casts = [
        'is_used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }

    public static function generateUniqueToken()
    {
        do {
            $token = strtoupper(substr(md5(uniqid(rand(), true)), 0, 12));
        } while (self::where('token', $token)->exists());

        return $token;
    }
}
