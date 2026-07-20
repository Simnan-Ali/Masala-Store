@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>

            Add Variant

            <small class="text-muted">

                ({{ $product->name }})

            </small>

        </h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.product-variants.store') }}" enctype="multipart/form-data"
              method="POST">

            @csrf

            @include('admin.product_variants._form')

        </form>

    </div>

</div>

@endsection