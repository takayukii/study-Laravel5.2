@extends('layout')

@section('content')
    <h1>{{ $article->title }}</h1>

    <hr/>

    <article>
        <div class="body">{{ $article->body }}</div>
    </article>

    <hr/>

    {!! link_to(action('ArticlesController@edit', [$article->id]), '編集', ['class' => 'btn btn-primary']) !!}
@endsection
