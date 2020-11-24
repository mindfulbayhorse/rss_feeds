@extends('layout')

@section('title','Edit rss feed')

@section('content')
<main>

<form action="/{{$category->path()}}" method="post">
  
  {{ method_field('PATCH') }}
  
  @include('rss.categories.form');
  
</form>

<form action="{{$category->path()}}" method="post">
  
  {{ method_field('DELETE') }}
  {{ csrf_field() }}
  
  <input type="hidden" name="id" value="{{$category->id}}"/>
  <input type="submit" value="Delete" name="delete" />
</form>

</main>


@endsection
