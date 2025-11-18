<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function store(Request $request)
    {
        $token = Token::create([
            'token' => Token::generateUniqueToken(),
        ]);

        return redirect()->back()->with('success', 'Token berhasil dibuat: ' . $token->token);
    }

    public function index()
    {
        $tokens = Token::where('is_used', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($tokens);
    }

    public function destroy(Token $token)
    {
        if ($token->is_used) {
            return redirect()->back()->withErrors(['error' => 'Token sudah digunakan, tidak bisa dihapus.']);
        }

        $token->delete();

        return redirect()->back()->with('success', 'Token berhasil dihapus.');
    }
}
