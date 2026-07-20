@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Edit Category</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.categories.update',$category) }}"
              method="POST"
              enctype="multipart/form-data">

            @method('PUT')

            @include('admin.categories._form')

        </form>

    </div>

</div>

@endsection