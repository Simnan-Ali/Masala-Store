@csrf

<div class="mb-3">
    <label class="form-label">Category Name</label>

    <input type="text"
           name="name"
           id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $category->name ?? '') }}">

    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">

<label>

Slug

</label>

<input type="text"
       id="slug"
       class="form-control"
       readonly>

</div>

<div class="mb-3">
    <label class="form-label">Image</label>

    <input type="file"
       id="image"
       name="image"
       class="form-control">

    <img id="preview"
     width="120"
     class="mt-2 rounded"
     @if(isset($category) && $category->image)
     src="{{ asset('storage/'.$category->image) }}"
     @endif>
</div>

<div class="mb-3">

    <label>Status</label>

    <select name="status" class="form-select">

        <option value="1"
            {{ old('status',$category->status ?? 1)==1?'selected':'' }}>
            Active
        </option>

        <option value="0"
            {{ old('status',$category->status ?? 1)==0?'selected':'' }}>
            Inactive
        </option>

    </select>

</div>

<button class="btn btn-success">

    Save Category

</button>

<a href="{{ route('admin.categories.index') }}"
   class="btn btn-secondary">

    Back

</a>

<script>

image.onchange=function(e){

preview.src=URL.createObjectURL(e.target.files[0]);

}


document
.getElementById('name')
.addEventListener('keyup',function(){

let slug=this.value
.toLowerCase()
.replace(/ /g,'-')
.replace(/[^\w-]+/g,'');

document
.getElementById('slug')
.value=slug;

});

</script>