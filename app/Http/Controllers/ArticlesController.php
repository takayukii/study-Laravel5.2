<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;

use App\Http\Requests;
use Carbon\Carbon;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::latest('published_at')->where('published_at', '<=', Carbon::now())->published()->get();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }

    public function store(ArticleRequest $request)
    {
        Article::create($request->all());

        \Session::flash('flash_message', '記事を作成しました');

        return redirect('articles');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);

        return view('articles.edit', compact('article'));
    }

    public function update($id, ArticleRequest $request)
    {
        $article = Article::findOrFail($id);

        $article->update($request->all());

        \Session::flash('flash_message', '記事を更新しました');

        return redirect(url('articles', [$article->id]));
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        \Session::flash('flash_message', '記事を削除しました');

        return redirect('articles');
    }
}
