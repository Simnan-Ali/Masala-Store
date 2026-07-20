@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Add Category</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.categories.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @include('admin.categories._form')

        </form>

    </div>

</div>

@endsection