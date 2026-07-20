<input type="hidden"
       name="product_id"
       value="{{ $product->id }}">

<div class="row">

    {{-- Variant Name --}}
    <div class="col-md-4 mb-3">

        <label class="form-label">Variant Name</label>

        <input
            type="text"
            id="variant_name"
            name="variant_name"
            class="form-control"
            placeholder="100gm / 250gm / 1Kg"
            value="{{ old('variant_name', $variant->variant_name ?? '') }}">

    </div>

    {{-- SKU --}}
    <div class="col-md-4 mb-3">

        <label class="form-label">SKU</label>

        <input
            type="text"
            id="sku"
            name="sku"
            class="form-control"
            readonly
            value="{{ old('sku', $variant->sku ?? $sku) }}">

    </div>

    {{-- Status --}}
    <div class="col-md-4 mb-3">

        <label class="form-label">Status</label>

        <select name="status" class="form-select">

            <option value="1"
                {{ old('status',$variant->status ?? 1)==1 ? 'selected' : '' }}>
                Active
            </option>

            <option value="0"
                {{ old('status',$variant->status ?? 1)==0 ? 'selected' : '' }}>
                Inactive
            </option>

        </select>

    </div>

</div>

<hr>

<div class="row">

    {{-- Purchase Price --}}
    <div class="col-md-3 mb-3">

        <label>Purchase Price</label>

        <input
            type="number"
            step="0.01"
            id="purchase_price"
            name="purchase_price"
            class="form-control"
            value="{{ old('purchase_price',$variant->purchase_price ?? 0) }}">

    </div>

    {{-- MRP --}}
    <div class="col-md-3 mb-3">

        <label>MRP</label>

        <input
            type="number"
            step="0.01"
            id="mrp"
            name="mrp"
            class="form-control"
            value="{{ old('mrp',$variant->mrp ?? 0) }}">

    </div>

    {{-- Selling Price --}}
    <div class="col-md-3 mb-3">

        <label>Selling Price</label>

        <input
            type="number"
            step="0.01"
            id="selling_price"
            name="selling_price"
            class="form-control"
            value="{{ old('selling_price',$variant->selling_price ?? 0) }}">

    </div>

    {{-- Stock --}}
    <div class="col-md-3 mb-3">

        <label>Stock</label>

        <input
            type="number"
            name="stock"
            class="form-control"
            value="{{ old('stock',$variant->stock ?? 0) }}">

    </div>

</div>

<div class="row">

    {{-- Discount --}}
    <div class="col-md-4 mb-3">

        <label>Discount (%)</label>

        <input
            type="text"
            id="discount_percent"
            class="form-control"
            readonly>

    </div>

    {{-- Profit --}}
    <div class="col-md-4 mb-3">

        <label>Profit</label>

        <input
            type="text"
            id="profit_amount"
            class="form-control"
            readonly>

    </div>

    {{-- Margin --}}
    <div class="col-md-4 mb-3">

        <label>Profit Margin (%)</label>

        <input
            type="text"
            id="profit_margin"
            class="form-control"
            readonly>

    </div>

</div>

<hr>

<div class="row">

    {{-- Weight --}}
    <div class="col-md-6 mb-3">

        <label>Weight</label>

        <input
            type="number"
            step="0.01"
            name="weight"
            class="form-control"
            value="{{ old('weight',$variant->weight ?? '') }}">

    </div>

    {{-- Unit --}}
    <div class="col-md-6 mb-3">

        <label>Unit</label>

        <select name="unit" class="form-select">

            @foreach(['Gram','Kg','Packet'] as $unit)

                <option
                    value="{{ $unit }}"
                    {{ old('unit',$variant->unit ?? '')==$unit?'selected':'' }}>

                    {{ $unit }}

                </option>

            @endforeach

        </select>

    </div>

</div>

<hr>

<div class="row">

    {{-- Variant Image --}}
    <div class="col-md-6">

        <label class="form-label">

            Variant Image

        </label>

        <input
            type="file"
            name="image"
            id="variantImage"
            class="form-control">

    </div>

    {{-- Preview --}}
    <div class="col-md-6">

        <img
            id="variantPreview"
            src="{{ isset($variant) && $variant->image ? asset('storage/'.$variant->image) : '' }}"
            width="160"
            class="img-thumbnail"
            style="{{ isset($variant) && $variant->image ? '' : 'display:none;' }}">

    </div>

</div>

<hr>

<div class="text-end">

    <a href="{{ route('admin.products.variants',$product) }}"
       class="btn btn-secondary">

        Back

    </a>

    <button class="btn btn-success">

        <i class="fa fa-save"></i>

        {{ isset($variant) ? 'Update Variant' : 'Save Variant' }}

    </button>

</div>

@push('scripts')

<script>

$(function(){

    // ==========================
    // Pricing Calculator
    // ==========================

    function calculatePricing(){

        let purchase = parseFloat($('#purchase_price').val()) || 0;

        let mrp = parseFloat($('#mrp').val()) || 0;

        let selling = parseFloat($('#selling_price').val()) || 0;

        let discount = 0;

        if(mrp > 0){

            discount = ((mrp - selling) / mrp) * 100;

        }

        let profit = selling - purchase;

        let margin = 0;

        if(selling > 0){

            margin = (profit / selling) * 100;

        }

        $('#discount_percent').val(discount.toFixed(2)+' %');

        $('#profit_amount').val(profit.toFixed(2));

        $('#profit_margin').val(margin.toFixed(2)+' %');

    }

    $('#purchase_price,#mrp,#selling_price')
        .on('keyup input change',calculatePricing);

    calculatePricing();

    // ==========================
    // Variant Image Preview
    // ==========================

    $('#variantImage').change(function(){

        let file = this.files[0];

        if(file){

            $('#variantPreview')
                .attr('src',URL.createObjectURL(file))
                .show();

        }

    });

});

</script>

@endpush