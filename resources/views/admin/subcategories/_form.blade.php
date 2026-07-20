@csrf

<div class="mb-3">

<label>Category</label>

<select name="category_id" class="form-select">

@foreach($categories as $category)

<option value="{{ $category->id }}"
{{ old('category_id',$subCategory->category_id ?? '')==$category->id?'selected':'' }}>

{{ $category->name }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Name</label>

<input type="text"
       id="name"
       name="name"
       class="form-control"
       value="{{ old('name',$subCategory->name ?? '') }}">
</div>
<div class="mb-3">

<label>Slug</label>

<input type="text"
       id="slug"
       class="form-control"
       readonly>

</div>
<div class="mb-3">

<label>Image</label>

<input type="file"
       id="image"
       name="image"
       class="form-control">

<img id="preview"
     class="mt-2 rounded"
     width="120"
     @if(isset($subCategory) && $subCategory->image)
     src="{{ asset('storage/'.$subCategory->image) }}"
     @endif>

</div>

<div class="mb-3">

<label>Status</label>

<select name="status" class="form-select">

<option value="1">Active</option>

<option value="0">Inactive</option>

</select>

</div>

<button class="btn btn-success">

Save

</button>

<script>

document.getElementById('name').addEventListener('keyup',function(){

let slug=this.value
.toLowerCase()
.trim()
.replace(/\s+/g,'-')
.replace(/[^\w\-]+/g,'');

document.getElementById('slug').value=slug;

});


document.getElementById('image').onchange=function(e){

preview.src=URL.createObjectURL(e.target.files[0]);

}

</script>