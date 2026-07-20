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

        <form method="GET"
            action="{{ route('admin.categories.index') }}"
            class="row mb-3">

            <div class="col-md-4">

                <input type="text"
                    class="form-control"
                    name="search"
                    placeholder="Search Category..."
                    value="{{ request('search') }}">

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary">

                    Search

                </button>

            </div>

        </form>

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

                        <a href="{{ route('admin.categories.edit',$category) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form class="deleteForm"
                            action="{{ route('admin.categories.destroy',$category) }}"
                            method="POST">

                        @csrf

                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">

                        Delete

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

        {{ $categories->links() }}

    </div>

</div>

<script>

document
.querySelectorAll('.deleteForm')
.forEach(function(form){

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



new DataTable('#categoryTable');

</script>
@endsection