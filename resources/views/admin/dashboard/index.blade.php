@extends('admin.layouts.master')

@section('content')

<h2 class="mb-4">

Dashboard

</h2>

<div class="row">

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h6>Total Categories</h6>
                <h2>0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h6>Total Products</h6>
                <h2>0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h6>Total Orders</h6>
                <h2>0</h2>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h6>Total Customers</h6>
                <h2>0</h2>
            </div>
        </div>
    </div>

</div>

@endsection