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

        return redirect(url('articles', [$article->id]));
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        $article->delete();

        return redirect('articles');
    }
}
