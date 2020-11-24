{{ csrf_field() }}
<input type="hidden" name="id" value="{{$category->id}}"/>
  
<div>
    <label for="title">Name: </label>
    <input type="text" name="name" value="{{$category->name}}"/>
</div>

<input type="submit" name="save" value="Save"/>