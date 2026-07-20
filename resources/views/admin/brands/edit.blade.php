@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Edit Brand</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.brands.update',$brand) }}"
              method="POST"
              enctype="multipart/form-data">

            @method('PUT')

            @include('admin.brands._form')

        </form>

    </div>

</div>

@endsection