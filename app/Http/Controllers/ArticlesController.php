<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;

use App\Http\Requests;
use Carbon\Carbon;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $articles = Article::latest('published_at')->where('published_at', '<=', Carbon::now())->published()->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function store(ArticleRequest $request)
    {
        \Auth::user()->articles()->create($request->all());
        \Session::flash('flash_message', '記事を作成しました');

        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Article $article, ArticleRequest $request)
    {
        $article->update($request->all());
        \Session::flash('flash_message', '記事を更新しました');

        return redirect()->route('articles.show', [$article->id]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        \Session::flash('flash_message', '記事を削除しました');

        return redirect()->route('articles.index');
    }
}
