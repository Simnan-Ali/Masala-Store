@extends('admin.layouts.master')

@section('content')

<div class="card">

<div class="card-header d-flex justify-content-between">

<h4>Sub Categories</h4>

<a href="{{ route('admin.sub-categories.create') }}"
class="btn btn-primary">

Add Sub Category

</a>

</div>

<div class="card-body">
<form method="GET"
      action="{{ route('admin.sub-categories.index') }}"
      class="row mb-3">

    <div class="col-md-4">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               class="form-control"
               placeholder="Search Sub Category...">

    </div>

    <div class="col-md-2">

        <button class="btn btn-primary">

            Search

        </button>

    </div>

</form>
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

<img src="{{ asset('storage/'.$subCategory->image) }}"
width="60">

@endif

</td>

<td>{{ $subCategory->category->name }}</td>

<td>{{ $subCategory->name }}</td>

<td>

@if($subCategory->status)

<span class="badge bg-success">Active</span>

@else

<span class="badge bg-danger">Inactive</span>

@endif

</td>

<td>

<a href="{{ route('admin.sub-categories.edit',$subCategory) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<form class="deleteForm"
      action="{{ route('admin.sub-categories.destroy',$subCategory) }}"
      method="POST">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $subCategories->links() }}

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




new DataTable('#subCategoryTable');
</script>
@endsection