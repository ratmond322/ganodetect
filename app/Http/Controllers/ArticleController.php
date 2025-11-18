<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    // daftar (dipakai kalau mau page artikel lengkap)
    public function index()
    {
        $articles = Article::orderBy('published_at','desc')->paginate(6);
        return view('articles.index', compact('articles'));
    }

    // show by slug
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        return view('articles.show', compact('article'));
    }
}
