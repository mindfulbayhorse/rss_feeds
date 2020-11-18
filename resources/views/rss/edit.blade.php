@extends('layout')

@section('title','Edit rss feed')

@section('content')
<main>

<form action="/rssfeed/{{$rssfeed->id}}" method="post">
  
  {{ method_field('PATCH') }}
  {{ csrf_field() }}
  
  <input type="hidden" name="id" value="{{$rssfeed->id}}"/>
  
  <div>
    <label for="url">url: </label>
    <input type="text" name="url" value="{{$rssfeed->url}}"/>
  </div>
  <div>
    <label for="title">Title: </label>
    <input type="text" name="title" value="{{$rssfeed->title}}"/>
  </div>
  <div>
  <label for="description">Description: </label>
    <input type="text" name="description" value="{{$rssfeed->description}}"/>
  </div>
  
  <input type="submit" name="save" value="Save"/>

</form>

<form action="/rssfeed/{{$rssfeed->id}}" method="post">
  
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
  
  <input type="hidden" name="id" value="{{$rssfeed->id}}"/>
  <input type="submit" value="Delete" name="delete" />
</form>

</main>


@endsection
