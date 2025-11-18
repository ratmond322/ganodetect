<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'author', 'image', 'excerpt', 'body', 'published_at'
    ];

    protected $dates = ['published_at'];

    // helper: set slug otomatis jika kosong
    public static function booted()
    {
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title) . '-' . time();
            }
        });
    }
}
