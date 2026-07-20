@csrf

<div class="card mb-4">

    <div class="card-header bg-primary text-white">

        <h5 class="mb-0">Basic Information</h5>

    </div>

    <div class="card-body">

        <div class="row">

            {{-- Category --}}
            <div class="col-md-4 mb-3">

                <label class="form-label">Category <span class="text-danger">*</span></label>

                <select name="category_id" id="category" class="form-select">

                    <option value="">Select Category</option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Sub Category --}}
            <div class="col-md-4 mb-3">

                <label class="form-label">Sub Category <span class="text-danger">*</span></label>

                <select name="sub_category_id" id="sub_category" class="form-select">

                    <option value="">Select Sub Category</option>

                    @foreach($subCategories as $subCategory)

                        <option value="{{ $subCategory->id }}"
                            {{ old('sub_category_id', $product->sub_category_id ?? '') == $subCategory->id ? 'selected' : '' }}>

                            {{ $subCategory->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            {{-- Brand --}}
            <div class="col-md-4 mb-3">

                <label class="form-label">Brand <span class="text-danger">*</span></label>

                <select name="brand_id" class="form-select">

                    <option value="">Select Brand</option>

                    @foreach($brands as $brand)

                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>

                            {{ $brand->name }}

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        <div class="row">

            {{-- Product Name --}}
            <div class="col-md-6 mb-3">

                <label class="form-label">Product Name</label>

                <input type="text"
                       id="name"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $product->name ?? '') }}">

            </div>

            {{-- Slug --}}
            <div class="col-md-3 mb-3">

                <label class="form-label">Slug</label>

                <input type="text"
                       id="slug"
                       class="form-control"
                       value="{{ old('slug', $product->slug ?? '') }}"
                       readonly>

            </div>

            {{-- SKU --}}
            <div class="col-md-3 mb-3">

                <label class="form-label">SKU</label>

                <input type="text"
                       id="sku"
                       class="form-control"
                       value="{{ old('sku', $product->sku ?? ('SKU'.time())) }}"
                       readonly>

            </div>

        </div>

    </div>

</div>
<div class="card mb-4">

    <div class="card-header bg-success text-white">

        <h5 class="mb-0">Pricing & Stock</h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-3">

                <label>Purchase Price</label>

                <input type="number"
                       step="0.01"
                       name="purchase_price"
                       class="form-control"
                       value="{{ old('purchase_price', $product->purchase_price ?? '') }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>MRP</label>

                <input type="number"
                       step="0.01"
                       name="mrp"
                       class="form-control"
                       value="{{ old('mrp', $product->mrp ?? '') }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Selling Price</label>

                <input type="number"
                       step="0.01"
                       name="selling_price"
                       class="form-control"
                       value="{{ old('selling_price', $product->selling_price ?? '') }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Stock</label>

                <input type="number"
                       name="stock"
                       class="form-control"
                       value="{{ old('stock', $product->stock ?? 0) }}">

            </div>

        </div>

        <div class="row">

            <div class="col-md-3 mb-3">

                <label>Weight</label>

                <input type="number"
                       step="0.01"
                       name="weight"
                       class="form-control"
                       value="{{ old('weight', $product->weight ?? '') }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Unit</label>

                <select name="unit" class="form-select">

                    @php
                        $units = ['Kg','Gram','Packet','Box','Piece'];
                    @endphp

                    @foreach($units as $unit)

                        <option value="{{ $unit }}"
                            {{ old('unit', $product->unit ?? '') == $unit ? 'selected' : '' }}>

                            {{ $unit }}

                        </option>

                    @endforeach

                </select>

            </div>

        </div>

    </div>

</div>

<div class="card mb-4">

    <div class="card-header bg-info text-white">

        <h5 class="mb-0">Product Images</h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6">

                <label class="form-label">Thumbnail</label>

                <input type="file"
                       id="thumbnail"
                       name="thumbnail"
                       class="form-control">

                <img id="thumbnailPreview"
                     class="img-thumbnail mt-3"
                     width="180"
                     @if(isset($product) && $product->thumbnail)
                        src="{{ asset('storage/'.$product->thumbnail) }}"
                     @endif>

            </div>

            <div class="col-md-6">

                <label class="form-label">

                    Product Gallery

                </label>

                <input type="file"
                       id="gallery"
                       name="gallery[]"
                       multiple
                       class="form-control">

                <div id="galleryPreview"
                     class="d-flex flex-wrap gap-2 mt-3">

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card mb-4">

    <div class="card-header bg-warning">

        <h5 class="mb-0">

            Product Description

        </h5>

    </div>

    <div class="card-body">

        <div class="mb-3">

            <label>

                Short Description

            </label>

            <textarea
                name="short_description"
                rows="3"
                class="form-control">{{ old('short_description',$product->short_description ?? '') }}</textarea>

        </div>

        <div class="mb-3">

            <label>

                Description

            </label>

            <textarea
                name="description"
                rows="6"
                class="form-control">{{ old('description',$product->description ?? '') }}</textarea>

        </div>

    </div>

</div>


<div class="card mb-4">

    <div class="card-header bg-secondary text-white">

        <h5 class="mb-0">

            Product Settings

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="featured"
                           value="1"
                           {{ old('featured',$product->featured ?? false) ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Featured Product

                    </label>

                </div>

            </div>

            <div class="col-md-4">

                <div class="form-check">

                    <input class="form-check-input"
                           type="checkbox"
                           name="trending"
                           value="1"
                           {{ old('trending',$product->trending ?? false) ? 'checked' : '' }}>

                    <label class="form-check-label">

                        Trending Product

                    </label>

                </div>

            </div>

            <div class="col-md-4">

                <label>Status</label>

                <select name="status"
                        class="form-select">

                    <option value="1"
                        {{ old('status',$product->status ?? 1)==1?'selected':'' }}>

                        Active

                    </option>

                    <option value="0"
                        {{ old('status',$product->status ?? 1)==0?'selected':'' }}>

                        Inactive

                    </option>

                </select>

            </div>

        </div>

    </div>

</div>

<div class="text-end">

    <a href="{{ route('admin.products.index') }}"
       class="btn btn-secondary">

        Cancel

    </a>

    <button class="btn btn-success">

        <i class="fa fa-save"></i>

        {{ isset($product) ? 'Update Product' : 'Save Product' }}

    </button>

</div>

@push('scripts')

<script>

document.getElementById('name').addEventListener('keyup',function(){

let slug=this.value
.toLowerCase()
.trim()
.replace(/\s+/g,'-')
.replace(/[^\w-]+/g,'');

document.getElementById('slug').value=slug;

});

document.getElementById('thumbnail').onchange=function(e){

document.getElementById('thumbnailPreview').src=
URL.createObjectURL(e.target.files[0]);

}

document.getElementById('gallery').onchange=function(){

let preview=document.getElementById('galleryPreview');

preview.innerHTML='';

Array.from(this.files).forEach(file=>{

let img=document.createElement('img');

img.src=URL.createObjectURL(file);

img.width=100;

img.className='img-thumbnail';

preview.appendChild(img);

});

}

</script>

@endpush