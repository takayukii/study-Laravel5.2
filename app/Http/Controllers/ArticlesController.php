<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

use App\Http\Requests;

class ArticlesController extends Controller
{
    public function index()
    {
        $articles = Article::all();
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

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|min:3',
            'body' => 'required',
            'published_at' => 'required|date',
        ];
        $this->validate($request, $rules);

        Article::create($request->all());
        return redirect('articles');
    }
}
