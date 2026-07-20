@extends('admin.layouts.master')

@section('content')

<div class="card shadow">

    <div class="card-header">

        <h4>Add Brand</h4>

    </div>

    <div class="card-body">

        <form action="{{ route('admin.brands.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @include('admin.brands._form')

        </form>

    </div>

</div>

@endsection