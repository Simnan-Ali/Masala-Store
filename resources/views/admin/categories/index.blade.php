@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">

        <h4>Categories</h4>

        <a href="{{ route('admin.categories.create') }}"
           class="btn btn-primary">

            Add Category

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <form method="GET" action="{{ route('admin.categories.index') }}" class="mb-4">

            <div class="row g-3">

                <div class="col-lg-5 col-md-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="🔍 Search Category...">
                </div>

                <div class="col-lg-auto col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-refresh me-1"></i> Clear
                        </a>
                    @endif
                </div>

            </div>

        </form>
        <div class="table-responsive">
            <table id="categoryTable" class="table table-bordered table-hover">
                <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Image</th>

                    <th>Name</th>

                    <th>Slug</th>

                    <th>Status</th>

                    <th width="180">Action</th>

                </tr>

                </thead>

                <tbody>

                @forelse($categories as $category)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>

                            @if($category->image)

                                <img src="{{ asset('storage/'.$category->image) }}"
                                    width="70">

                            @endif

                        </td>

                        <td>{{ $category->name }}</td>

                        <td>{{ $category->slug }}</td>

                        <td>

                            @if($category->status)

                            <span class="badge bg-success">

                            Active

                            </span>

                            @else

                            <span class="badge bg-danger">

                            Inactive

                            </span>

                            @endif

                        </td>
                        <td>

                            <a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-warning btn-sm">

                                <i class="fa fa-edit"></i>

                            </a>

                            <form class="deleteForm d-inline" method="POST" action="{{ route('admin.categories.destroy',$category) }}">

                                @csrf @method('DELETE')

                                <button class="btn btn-danger btn-sm">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Categories Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>
        </div>
        {{ $categories->links('pagination::bootstrap-5') }}


    </div>

</div>

<script>

document .querySelectorAll('.deleteForm').forEach(function(form){
    form.addEventListener('submit',function(e){
        e.preventDefault();
            Swal.fire({
                title:'Delete?',
                text:'Category will be deleted',
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
@endsection