<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('created_at','desc')->take(10)->get();
        return view('Admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('Admin.articles.create');
    }

    public function store(Request $request)
    {
        // simple stub: validate minimal fields and create
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
        ]);
        $article = Article::create(array_merge($data, ['published_at' => now()]));
        return redirect()->route('admin.articles.index')->with('status','Article created.');
    }

    public function show(Article $article)
    {
        return view('Admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('Admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
        ]);
        $article->update($data);
        return redirect()->route('admin.articles.index')->with('status','Article updated.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('status','Article deleted.');
    }
}
