@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Edit Variant</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.product-variants.update',$variant) }}" enctype="multipart/form-data"
              method="POST">

            @csrf
            @method('PUT')

            @include('admin.product_variants._form')

        </form>

    </div>

</div>

@endsection