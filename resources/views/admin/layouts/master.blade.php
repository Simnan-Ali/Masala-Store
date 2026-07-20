<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Masala Store Admin</title>

@vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body>

@include('admin.layouts.navbar')

<div class="container-fluid">

    <div class="row">

        @include('admin.layouts.sidebar')

        <div class="col-md-10 content p-4">

            @yield('content')

        </div>

    </div>

</div>

@include('admin.layouts.footer')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

@stack('scripts')

</body>

</html>