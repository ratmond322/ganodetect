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
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug',
            'author' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
            $data['image'] = $imagePath;
        }

        // Set published_at to now if not provided
        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $article = Article::create($data);
        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dibuat!');
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
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $article->id,
            'author' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'published_at' => 'nullable|date',
        ]);

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = \Str::slug($data['title']);
        }

        // Handle image removal
        if ($request->has('remove_image')) {
            if ($article->image && !\Str::startsWith($article->image, 'http')) {
                \Storage::disk('public')->delete($article->image);
            }
            $data['image'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($article->image && !\Str::startsWith($article->image, 'http')) {
                \Storage::disk('public')->delete($article->image);
            }
            $imagePath = $request->file('image')->store('articles', 'public');
            $data['image'] = $imagePath;
        }

        $article->update($data);
        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diupdate!');
    }

    public function destroy(Article $article)
    {
        // Delete image if exists
        if ($article->image && !\Str::startsWith($article->image, 'http')) {
            \Storage::disk('public')->delete($article->image);
        }
        
        $article->delete();
        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus!');
    }
}
