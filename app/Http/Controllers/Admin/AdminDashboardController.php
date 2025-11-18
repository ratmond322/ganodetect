<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Token;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $articlesCount = Article::count();
        $recentArticles = Article::orderBy('created_at','desc')->take(5)->get();
        
        // Token statistics
        $totalTokens = Token::count();
        $usedTokens = Token::where('is_used', true)->count();
        $activeTokens = Token::where('is_used', false)->get();
        
        // User statistics
        $totalCustomers = User::where('is_admin', false)->count();

        return view('admin.layouts.dashboard', compact(
            'articlesCount',
            'recentArticles',
            'totalTokens',
            'usedTokens',
            'activeTokens',
            'totalCustomers'
        ));
    }
}
