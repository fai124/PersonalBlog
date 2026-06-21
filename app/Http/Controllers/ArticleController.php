<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Auth::user()->articles()->with('user')->latest()->paginate(10);
        return response()->json($articles);
    }
    
    public function store(StoreArticleRequest $request)
    {
        $article = new Article();
        $article->user_id = Auth::id();
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();
        
        return response()->json(['id' => $article->id]);
    }
    
    public function show($id)
    {
        $article = Article::with('user')->findOrFail($id);
        
        $isAuthor = false;
        if (Auth::check()) {
            $isAuthor = Auth::id() === $article->user_id;
        }
        
        return response()->json([
            'article' => $article,
            'isAuthor' => $isAuthor
        ]);
    }
    
    public function update(UpdateArticleRequest $request, Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            return response()->json(['message' => 'Нет прав'], 403);
        }
        
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();
        
        return response()->json(['id' => $article->id]);
    }
    
    public function destroy(Article $article)
    {
        if (Auth::id() !== $article->user_id) {
            return response()->json(['message' => 'Нет прав'], 403);
        }
        
        $article->delete();
        return response()->json(['message' => 'ok']);
    }
    
    public function publicIndex()
    {
        $articles = Article::with('user')->latest()->paginate(10);
        return response()->json($articles);
    }
    
    public function publicShow($id)
    {
        $article = Article::with('user')->findOrFail($id);
        return response()->json(['article' => $article]);
    }
    
    public function userArticles(User $user)
    {
        $articles = $user->articles()->with('user')->latest()->get();
        return response()->json($articles);
    }
}