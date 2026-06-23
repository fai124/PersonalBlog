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
        $articles = Auth::user()->articles()->with('user')->get();
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
        if (Auth::check()) {
            $isAuthor = Auth::id() === $article->user_id;
        }
        return response()->json(['article' => $article,'isAuthor' => $isAuthor]);
    }
    
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save();
        return response()->json(['id' => $article->id]);
    }
    
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return response()->json(['message' => 'ok']);
    }
    

    public function article()
    {
        $articles = Article::with('user')->get();
        return response()->json($articles);
    }
    
    public function articleOne($id)
    {
        $article = Article::with('user')->findOrFail($id);
        return response()->json(['article' => $article]);
    }
    
    public function articleUser($user)
    {
        $user = User::findOrFail($user);
        $articles = $user->articles()->with('user')->get();
        return response()->json($articles);
    }
}