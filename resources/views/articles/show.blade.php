@extends('layout')

@section('content')
    <h1>{{ $article->title }}</h1>

    <hr/>

    <article>
        <div class="body">{{ $article->body }}</div>
    </article>

    @unless ($article->tags->isEmpty())
        <h5>Tags:</h5>
        <ul>
            @foreach($article->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    @endunless

    @if (Auth::check())
        <hr/>

        {!! link_to_route('articles.edit', '編集', [$article->id], ['class' => 'btn btn-primary']) !!}

        <br/>
        <br/>

        {!! delete_form(['articles.destroy', $article->id]) !!}
    @endif
@endsection
