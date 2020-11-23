@extends('layout')

@section('title','RSS categories')

@section('content')
<a href="/categories/create" class="btn">Add category</a>
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
        @foreach  ($categories as $category)
          <tr>
            <td>{{$category->id}}</td>
            <td><a href="/categories/{{$category->id}}/">{{$category->name}}</a></td>
          </tr>
        @endforeach
      </tr>
    </tbody>
   </table>

</main>
  

@endsection