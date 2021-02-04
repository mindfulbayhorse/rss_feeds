@extends('layout')

@section('title','Create rss feed')

@section('left_sidebar')
    
@endsection

@section('content')

    @section('breadcrumbes')
        @include('navigation.breadcrumbes')
    @endsection
    
    <main>
    
       @if ($errors->any())
           
           @foreach ($errors->all() as $text)
               <p>{{ $text }}</p>
           @endforeach
           
        @endif
        
        <form method="post" action="/rss" class="feed-new">
            {{ csrf_field() }}
            
            <div class="required">
                <label for="url">url: <span>*</span></label>
                <input type="txt" 
                    name="url" 
                    value="{{ old('url') }}"
                    class="url @if ($errors->has('url')) {{ 'incorrect' }} @endif"/>
            </div>
            <div>
                <label for="title">Title: </label>
                <input type="txt" 
                    name="title" 
                    value="{{ old('title') }}"
                    class="title {{ $errors->has('description') ? 'incorrect' : '' }}"/>
            </div>
            <div>
                <label for="description">Description: </label>
                <textarea name="description">{{ old('description') }}</textarea>
            </div>
            
            <div class="complex category">
                <label for="categories">Category: </label>
                <select name="category"
                    id="category">
    	            <options>
    	                <option value="">Choose category</option>
                         @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</options>
                         @endforeach
    	            </options>
                </select>
                <category-form unique="newCategory"></category-form>
            </div>
      
      <input type="submit" name="save" value="Save"/>
    
    </form>
    
    </main>

@endsection
