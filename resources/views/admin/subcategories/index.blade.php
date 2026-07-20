@extends('admin.layouts.master') @section('content')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h4>Sub Categories</h4>

        <a href="{{ route('admin.sub-categories.create') }}" class="btn btn-primary">

            Add Sub Category

        </a>

    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('admin.sub-categories.index') }}" class="mb-4">

            <div class="row g-3">

                <div class="col-lg-5 col-md-6">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="🔍 Search Sub Category...">
                </div>

                <div class="col-lg-auto col-md-auto d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search me-1"></i> Search
                    </button>

                    @if(request()->filled('search'))
                        <a href="{{ route('admin.sub-categories.index') }}" class="btn btn-outline-danger">
                            <i class="fa fa-refresh me-1"></i> Clear
                        </a>
                    @endif
                </div>

            </div>

        </form>
        <div class="table-responsive">
            <table id="subCategoryTable" class="table table-bordered table-hover">
                <thead class="table-dark">

                    <tr>

                        <th>#</th>

                        <th>Image</th>

                        <th>Category</th>

                        <th>Name</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($subCategories as $subCategory)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>

                            @if($subCategory->image)

                            <img src="{{ asset('storage/'.$subCategory->image) }}" width="60"> @endif

                        </td>

                        <td>{{ $subCategory->category->name }}</td>

                        <td>{{ $subCategory->name }}</td>

                        <td>

                            @if($subCategory->status)

                            <span class="badge bg-success">Active</span> @else

                            <span class="badge bg-danger">Inactive</span> @endif

                        </td>
                        <td>

                            <a href="{{ route('admin.sub-categories.edit',$subCategory) }}" class="btn btn-warning btn-sm">

                                <i class="fa fa-edit"></i>

                            </a>

                            <form class="deleteForm d-inline" method="POST" action="{{ route('admin.sub-categories.destroy',$subCategory) }}">

                                @csrf @method('DELETE')

                                <button class="btn btn-danger btn-sm">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </form>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>
        </div>
        {{ $subCategories->links('pagination::bootstrap-5') }}

    </div>

</div>

<script>
    document.querySelectorAll('.deleteForm').forEach(function(form){    
        form.addEventListener('submit',function(e){    
            e.preventDefault();    
                Swal.fire({        
                    title:'Delete?',        
                    text:'This Sub Category will be deleted.',                
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