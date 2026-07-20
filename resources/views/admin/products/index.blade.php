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

        <form method="GET" class="row mb-4">

            <div class="col-md-4">

                <input type="text" name="search" class="form-control" placeholder="Search Product..." value="{{ request('search') }}">

            </div>

            <div class="col-md-3">

                <select name="category" class="form-select">

                    <option value="">

                        All Categories

                    </option>

                    @foreach($categories as $category)

                    <option value="{{ $category->id }}" {{ request( 'category')==$category->id?'selected':'' }}> {{ $category->name }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-3">

                <select name="brand" class="form-select">

                    <option value="">

                        All Brands

                    </option>

                    @foreach($brands as $brand)

                    <option value="{{ $brand->id }}" {{ request( 'brand')==$brand->id?'selected':'' }}> {{ $brand->name }}

                    </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-2">

                <button class="btn btn-dark w-100">

                    Search

                </button>

            </div>

        </form>

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

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        @if($product->thumbnail)

                        <img src="{{ asset('storage/'.$product->thumbnail) }}" width="70" class="rounded"> @endif

                    </td>

                    <td>{{ $product->name }}</td>

                    <td>{{ $product->category->name }}</td>

                    <td>{{ $product->subCategory->name }}</td>

                    <td>{{ $product->brand->name }}</td>

                    <td>₹ {{ number_format($product->selling_price,2) }}</td>

                    <td>

                        @if($product->stock>0)

                        <span class="badge bg-success">

                                {{ $product->stock }}

                            </span> @else

                        <span class="badge bg-danger">

                                Out of Stock

                            </span> @endif

                    </td>

                    <td>

                        @if($product->status)

                        <span class="badge bg-success">

                                Active

                            </span> @else

                        <span class="badge bg-danger">

                                Inactive

                            </span> @endif

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

        {{ $products->links() }}

    </div>

</div>

@endsection @push('scripts')

<script>
    document.querySelectorAll('.deleteForm').forEach(function(form){
    
    form.addEventListener('submit',function(e){
    
    e.preventDefault();
    
    Swal.fire({
    
    title:'Delete Product?',
    
    text:'This product will be deleted.',
    
    icon:'warning',
    
    showCancelButton:true,
    
    confirmButtonText:'Delete'
    
    }).then((result)=>{
    
    if(result.isConfirmed){
    
    form.submit();
    
    }
    
    });
    
    });
    
    });
</script>

@endpush