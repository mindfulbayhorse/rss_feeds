@extends('layout')

@section('title','Edit rss feed')

@section('content')
<main>
    <h1>{{$rssfeed->title}}</h1>
    
    <div>
        <p><b>Description</b></p>
        <p>{{$rssfeed->description}}</p>
    </div>
    
    <div>
        <p><b>URL</b></p>
        <p><a href="{{$rssfeed->url}}">Link to RSS feed</a></p>
    </div>
    
    <div>
      <a href="/rssfeed/{{$rssfeed->id}}/edit/">Edit</a>
    </div>
      
</main>


@endsection