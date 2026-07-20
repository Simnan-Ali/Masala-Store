@extends('admin.layouts.master')

@section('content')

<div class="card">

<div class="card-header">

<h4>Edit Sub Category</h4>

</div>

<div class="card-body">

<form method="POST"
action="{{ route('admin.sub-categories.update',$subCategory) }}"
enctype="multipart/form-data">

@method('PUT')

@include('admin.subcategories._form')

</form>

</div>

</div>

@endsection