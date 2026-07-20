@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Brand Management
        </h4>

        <a href="{{ route('admin.brands.create') }}"
           class="btn btn-primary">

            <i class="fa fa-plus"></i>

            Add Brand

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <form method="GET"
              action="{{ route('admin.brands.index') }}"
              class="row mb-3">

            <div class="col-md-4">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Search Brand">

            </div>

            <div class="col-md-2">

                <button class="btn btn-primary">

                    <i class="fa fa-search"></i>

                    Search

                </button>

            </div>

        </form>

        <table id="brandTable"
               class="table table-bordered table-hover">

            <thead class="table-dark">

            <tr>

                <th>#</th>

                <th>Logo</th>

                <th>Name</th>

                <th>Slug</th>

                <th>Description</th>

                <th>Status</th>

                <th width="180">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($brands as $brand)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>

                        @if($brand->logo)

                            <img src="{{ asset('storage/'.$brand->logo) }}"
                                 width="70"
                                 class="rounded">

                        @else

                            <span class="text-muted">

                                No Logo

                            </span>

                        @endif

                    </td>

                    <td>

                        {{ $brand->name }}

                    </td>

                    <td>

                        {{ $brand->slug }}

                    </td>

                    <td>

                        {{ Str::limit($brand->description,40) }}

                    </td>

                    <td>

                        @if($brand->status)

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

                        <a href="{{ route('admin.brands.edit',$brand) }}"
                           class="btn btn-warning btn-sm">

                            <i class="fa fa-edit"></i>

                        </a>

                        <form class="deleteForm d-inline"
                              action="{{ route('admin.brands.destroy',$brand) }}"
                              method="POST">

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

                    <td colspan="7"
                        class="text-center">

                        No Brand Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

        {{ $brands->links() }}

    </div>

</div>

@endsection

@push('scripts')

<script>

new DataTable('#brandTable');

document.querySelectorAll('.deleteForm').forEach(function(form){

form.addEventListener('submit',function(e){

e.preventDefault();

Swal.fire({

title:'Delete Brand?',

text:'This brand will be deleted.',

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