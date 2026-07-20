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

</body>
</html>