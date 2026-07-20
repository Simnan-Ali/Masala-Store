@extends('admin.layouts.master')

@section('content')

<div class="card">

<div class="card-header">

<h4>Add Sub Category</h4>

</div>

<div class="card-body">

<form method="POST"
action="{{ route('admin.sub-categories.store') }}"
enctype="multipart/form-data">

@include('admin.subcategories._form')

</form>

</div>

</div>

@endsection