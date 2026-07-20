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

                <select name="category_id"
                        id="category"
                        class="form-select"
                        data-url="{{ url('admin/get-subcategories') }}">
                    <option value="">Select Category</option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}"
                            {{ old('category_id',$product->category_id ?? '')==$category->id?'selected':'' }}>

                            {{ $category->name }}

                        </option>

                    @endforeach

                </select>

                @error('category_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror

            </div>

            {{-- Sub Category --}}
            <div class="col-md-4 mb-3">

                <label class="form-label">Sub Category <span class="text-danger">*</span></label>

                <select name="sub_category_id"
                        id="sub_category"
                        class="form-select">

                    <option value="">Select Sub Category</option>

                    @if(isset($product))

                    @foreach($subCategories->where('category_id',$product->category_id) as $sub)

                    <option value="{{ $sub->id }}"
                    {{ old('sub_category_id',$product->sub_category_id)==$sub->id?'selected':'' }}>

                    {{ $sub->name }}

                    </option>

                    @endforeach

                    @endif

                </select>

                @error('sub_category_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror

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

                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

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
                    name="sku"
                    id="sku"
                    class="form-control"
                    value="{{ old('sku', $product->sku ?? $sku) }}"
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
                       id="purchase_price"
                       class="form-control"
                       value="{{ old('purchase_price', $product->purchase_price ?? '') }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>MRP</label>

                <input type="number"
                       step="0.01"
                       id="mrp"
                       name="mrp"
                       class="form-control"
                       value="{{ old('mrp', $product->mrp ?? '') }}">

            </div>

            <div class="col-md-3 mb-3">

                <label>Selling Price</label>

                <input type="number"
                       step="0.01"
                       id="selling_price"
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

            <div class="col-md-3 mb-3">

                <label>Discount (%)</label>

                <input type="text"
                    id="discount_percent"
                    class="form-control"
                    readonly>

            </div>

            <div class="col-md-3 mb-3">

                <label>Profit</label>

                <input type="text"
                    id="profit_amount"
                    class="form-control"
                    readonly>

            </div>

            <div class="col-md-3 mb-3">

                <label>Profit Margin (%)</label>

                <input type="text"
                    id="profit_margin"
                    class="form-control"
                    readonly>

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

                <img
                id="thumbnailPreview"
                src="{{ isset($product) && $product->thumbnail ? asset('storage/'.$product->thumbnail) : '' }}"
                class="img-thumbnail mt-3"
                width="180"
                style="{{ isset($product) && $product->thumbnail ? '' : 'display:none;' }}">

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

                @if(isset($product) && $product->images->count())

                <hr>

                <h6>Existing Gallery</h6>

                <div class="d-flex flex-wrap gap-3">

                @foreach($product->images as $image)

                <div class="text-center">

                    <img src="{{ asset('storage/'.$image->image) }}"
                        width="100"
                        class="img-thumbnail">

                    <form action="{{ route('admin.products.gallery.destroy',$image) }}"
                        method="POST"
                        class="mt-2">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">

                            Delete

                        </button>

                    </form>

                </div>

                @endforeach

                </div>

                @endif

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
                id="short_description"
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
                id="description"
                rows="6"
                class="form-control">{{ old('description',$product->description ?? '') }}</textarea>

        </div>

    </div>

</div>

<div class="card mb-4">

    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">SEO Information</h5>
    </div>

    <div class="card-body">

        <div class="mb-3">

            <label>Meta Title</label>

            <input
                type="text"
                id="meta_title"
                name="meta_title"
                maxlength="60"
                class="form-control"
                value="{{ old('meta_title',$product->meta_title ?? '') }}">

            <small class="text-muted">

                <span id="titleCount">0</span>/60 Characters

            </small>

        </div>

        <div class="mb-3">

            <label>Meta Description</label>

            <textarea
                id="meta_description"
                name="meta_description"
                rows="4"
                maxlength="160"
                class="form-control">{{ old('meta_description',$product->meta_description ?? '') }}</textarea>

            <small class="text-muted">

                <span id="descriptionCount">0</span>/160 Characters

            </small>

        </div>

        <div class="mb-3">
            <label>Meta Keywords</label>

            <textarea
                id="meta_keywords"
                name="meta_keywords"
                rows="3"
                class="form-control"
                placeholder="haldi, turmeric, organic, masala">{{ old('meta_keywords', $product->meta_keywords ?? '') }}</textarea>
        </div>

        <div class="mt-3">

            <h6>

                SEO Score

            </h6>

            <div class="progress">

                <div id="seoScoreBar"
                    class="progress-bar bg-danger"
                    style="width:0%">

                    0%

                </div>

            </div>

        </div>

    </div>

</div>


<div class="card mb-4">

    <div class="card-header">

        Google Search Preview

    </div>

    <div class="card-body">

        <h5 id="googleTitle"
            style="color:#1a0dab">

            Product Title

        </h5>

        <small style="color:green">

            https://masalastore.com/product

        </small>

        <p id="googleDescription"
           class="mt-2 text-muted">

            Meta Description Preview...

        </p>

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

<script src="{{ asset('assets/js/product.js') }}"></script>

@endpush