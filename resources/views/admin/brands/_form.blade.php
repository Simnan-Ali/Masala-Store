@csrf

<div class="mb-3">

    <label>Brand Name</label>

    <input type="text"
           id="name"
           name="name"
           class="form-control"
           value="{{ old('name',$brand->name ?? '') }}">

</div>

<div class="mb-3">

    <label>Slug</label>

    <input type="text"
           id="slug"
           class="form-control"
           readonly>

</div>

<div class="mb-3">

    <label>Logo</label>

    <input type="file"
           id="logo"
           name="logo"
           class="form-control">

    <img id="preview"
         class="mt-2 rounded"
         width="120"
         @if(isset($brand) && $brand->logo)
         src="{{ asset('storage/'.$brand->logo) }}"
         @endif>

</div>

<div class="mb-3">

    <label>Description</label>

    <textarea name="description"
              class="form-control"
              rows="4">{{ old('description',$brand->description ?? '') }}</textarea>

</div>

<div class="mb-3">

    <label>Status</label>

    <select name="status" class="form-select">

        <option value="1"
            {{ old('status',$brand->status ?? 1)==1?'selected':'' }}>
            Active
        </option>

        <option value="0"
            {{ old('status',$brand->status ?? 1)==0?'selected':'' }}>
            Inactive
        </option>

    </select>

</div>

<button class="btn btn-success">
    Save Brand
</button>

<a href="{{ route('admin.brands.index') }}"
   class="btn btn-secondary">
    Back
</a>

<script>
document.getElementById('name').addEventListener('keyup', function () {
    let slug = this.value.toLowerCase()
        .trim()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '');

    document.getElementById('slug').value = slug;
});

document.getElementById('logo').onchange = function (e) {
    document.getElementById('preview').src =
        URL.createObjectURL(e.target.files[0]);
};
</script>