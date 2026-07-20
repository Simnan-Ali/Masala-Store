@extends('admin.layouts.master') @section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4>Products</h4>

        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">

            <i class="fa fa-plus"></i> Add Product

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

        @endif

        <form method="GET" action="{{ route('admin.products.index') }}" class="mb-4">

            <div class="row g-3">

                <div class="col-lg-3 col-md-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="🔍 Search Product..." style="height: 45px;">
                </div>

                <div class="col-lg-3 col-md-6">
                    <select name="category" class="form-select" style="height: 45px;">
                        <option value="">All Categories</option>

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-3 col-md-6">
                    <select name="brand" class="form-select" style="height: 45px;">
                        <option value="">All Brands</option>

                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-auto col-md-6 d-flex gap-2" style="height: 45px;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>

                    @if(request()->filled('search') || request()->filled('category') || request()->filled('brand'))
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-refresh me-1"></i> Clear
                        </a>
                    @endif
                </div>

            </div>

        </form>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Category</th>

                        <th>Sub Category</th>

                        <th>Brand</th>

                        <th>Price</th>

                        <th>Stock</th>

                        <th>Status</th>

                        <th>Featured</th>

                        <th>Trending</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($products as $product)

                    <tr>

                        <td>{{ $products->firstItem()+$loop->index }}</td>

                        <td>

                            @if($product->thumbnail)
                                <img
                                src="{{ asset('storage/'.$product->thumbnail) }}"
                                width="70"
                                height="70"
                                class="rounded border"
                                style="object-fit:cover"> 
                            @endif

                        </td>

                        <td>{{ $product->name }}</td>

                        <td>{{ $product->category->name }}</td>

                        <td>{{ $product->subCategory->name }}</td>

                        <td>{{ $product->brand->name }}</td>

                        <td>₹ {{ number_format($product->selling_price,2) }}</td>

                        <td>

                        @if($product->stock==0)
                                <span class="badge bg-danger">
                                Out Of Stock
                                </span>
                                @elseif($product->stock<=10)
                                <span class="badge bg-warning">
                                Low Stock ({{ $product->stock }})
                                </span>
                                @else
                                <span class="badge bg-success">
                                {{ $product->stock }}
                                </span>
                            @endif

                        </td>

                        <td>
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input statusToggle"
                                    type="checkbox"
                                    data-id="{{ $product->id }}"
                                    {{ $product->status ? 'checked' : '' }}>
                            </div>
                        </td>

                        <td>

                            @if($product->featured) ⭐ @else - @endif

                        </td>

                        <td>

                            @if($product->trending) 🔥 @else - @endif

                        </td>

                        <td>

                            <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-warning btn-sm">

                                <i class="fa fa-edit"></i>

                            </a>

                            <form class="deleteForm d-inline" method="POST" action="{{ route('admin.products.destroy',$product) }}">

                                @csrf @method('DELETE')

                                <button class="btn btn-danger btn-sm">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="12" class="text-center">

                            No Products Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

        {{ $products->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection 
@push('scripts')

<script>
    $('.deleteForm').submit(function(e){
        e.preventDefault();
        let form=this;
        Swal.fire({
            title:'Delete Product?',
            text:'You cannot undo this action.',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#d33',
            cancelButtonColor:'#3085d6',
            confirmButtonText:'Yes, Delete'
        }).then((result)=>{
            if(result.isConfirmed){
                form.submit();
            }
        });
    });


    $('.statusToggle').change(function(){
    let id=$(this).data('id');
    $.ajax({
        url:'/admin/products/'+id+'/change-status',
        type:'POST',
        data:{
            _token:"{{ csrf_token() }}"
        },
        success:function(){
            Swal.fire({
                icon:'success',
                title:'Status Updated',
                timer:1000,
                showConfirmButton:false
            });
        }
    });
});
</script>


@endpush