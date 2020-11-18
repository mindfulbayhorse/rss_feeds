@extends('layout')

@section('title','List of rss feeds')

@section('content')
<a href="/rss/create" class="btn">Add rss feed</a>
<main>
    
 <table class="feed_list">
    <thead>
      <tr>
        <td>ID</td>
        <td>Title</td>
        <td>Description</td>
        <td>URL</td>
        <td>Category</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        @foreach  ($rss as $feed)
          <tr>
            <td>{{$feed->id}}</td>
            <td><a href="/rss/{{$feed->id}}/">{{$feed->title}}</a></td>
            <td>{{$feed->description}}</td>
            <td>{{$feed->url}}</td>
            <td>{{$feed->category}}</td>
          </tr>
        @endforeach
      </tr>
    </tbody>
   </table>

</main>
  

@endsection
