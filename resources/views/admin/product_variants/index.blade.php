@extends('admin.layouts.master')

@section('content')
<script>
    const variantStatusUrl = "{{ url('admin/product-variants') }}";
</script>
<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>
            {{ $product->name }} Variants
        </h4>

        <a href="{{ route('admin.product-variants.create',['product'=>$product->id]) }}"
           class="btn btn-primary">

            <i class="fa fa-plus"></i>
            Add Variant

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- <form method="GET" class="row mb-3">

            <div class="col-md-6">

                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Search Variant..."
                    value="{{ request('search') }}">

            </div>

            <div class="col-md-2">

                <button class="btn btn-dark w-100">
                    Search
                </button>

            </div>

        </form> -->
        <form method="GET"
            action="{{ route('admin.products.variants', $product) }}"
            class="mb-4">

            <div class="row g-3">

                <div class="col-lg-5 col-md-6">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Variant..."
                        value="{{ request('search') }}">

                </div>

                <div class="col-lg-auto col-md-6 d-flex gap-2">

                    <button type="submit" class="btn btn-primary">

                        <i class="fa fa-search me-1"></i>
                        Search

                    </button>

                    @if(request()->filled('search'))

                        <a href="{{ route('admin.products.variants', $product) }}"
                        class="btn btn-outline-danger">

                            <i class="fa fa-refresh me-1"></i>
                            Clear

                        </a>

                    @endif

                </div>

            </div>

        </form>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

            <tr>

                <th>#</th>
                <th>Image</th>
                <th>Variant</th>
                <th>SKU</th>
                <th>Weight</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th width="150">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($variants as $variant)

            <tr>

                <td>{{ $variants->firstItem()+$loop->index }}</td>
                <td>

                    @if($variant->image)

                        <img
                            src="{{ asset('storage/'.$variant->image) }}"
                            width="60"
                            height="60"
                            class="rounded border"
                            style="object-fit:cover;">

                    @else

                        <span class="text-muted">No Image</span>

                    @endif

                </td>

                <td>{{ $variant->variant_name }}</td>

                <td>{{ $variant->sku }}</td>

                <td>
                    {{ $variant->weight }}
                    {{ $variant->unit }}
                </td>

                <td>
                    ₹ {{ number_format($variant->selling_price,2) }}
                </td>

                <td>

                    @if($variant->stock==0)

                        <span class="badge bg-danger">
                            Out Of Stock
                        </span>

                    @elseif($variant->stock<=10)

                        <span class="badge bg-warning">
                            Low ({{ $variant->stock }})
                        </span>

                    @else

                        <span class="badge bg-success">
                            {{ $variant->stock }}
                        </span>

                    @endif

                </td>

                <td>

                    <div class="form-check form-switch">

                        <input
                            class="form-check-input variantStatusToggle"
                            type="checkbox"
                            data-id="{{ $variant->id }}"
                            {{ $variant->status ? 'checked' : '' }}>

                    </div>

                </td>

                <td>

                    <a href="{{ route('admin.product-variants.edit',$variant) }}"
                       class="btn btn-warning btn-sm">

                        <i class="fa fa-edit"></i>

                    </a>

                    <form
                        method="POST"
                        class="deleteForm d-inline"
                        action="{{ route('admin.product-variants.destroy',$variant) }}">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">

                            <i class="fa fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="8" class="text-center">

                    No Variants Found

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

        {{ $variants->links() }}

    </div>

</div>
@push('scripts')

<script>

$('.deleteForm').submit(function(e){

    e.preventDefault();

    let form=this;

    Swal.fire({

        title:'Delete Variant?',

        text:'You cannot undo this action.',

        icon:'warning',

        showCancelButton:true,

        confirmButtonColor:'#d33',

        confirmButtonText:'Delete'

    }).then((result)=>{

        if(result.isConfirmed){

            form.submit();

        }

    });

});

// =========
// variantStatusToggle
// =========
$('.variantStatusToggle').change(function () {

    let checkbox = $(this);

    let id = checkbox.data('id');

    $.ajax({

        url: variantStatusUrl + "/" + id + "/change-status",

        type: "POST",

        data: {
            _token: "{{ csrf_token() }}"
        },

        success: function (response) {

            Swal.fire({
                icon: 'success',
                title: response.message,
                timer: 1200,
                showConfirmButton: false
            });

        },

        error: function () {

            checkbox.prop('checked', !checkbox.prop('checked'));

            Swal.fire({
                icon: 'error',
                title: 'Something went wrong.'
            });

        }

    });

});

// =======

$('#variantImage').change(function(){

    let file = this.files[0];

    if(file){

        $('#variantPreview')
            .attr('src', URL.createObjectURL(file))
            .show();

    }

});
</script>

@endpush
@endsection