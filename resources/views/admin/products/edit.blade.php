@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Edit Product</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.products.update',$product) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            @include('admin.products._form')

        </form>

    </div>

</div>

@endsection