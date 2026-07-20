@extends('admin.layouts.master') @section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Add Product</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">

            @include('admin.products._form')

        </form>

    </div>

</div>

@endsection