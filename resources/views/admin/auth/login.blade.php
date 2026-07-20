<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Login | Masala Store</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center vh-100">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-dark text-white text-center py-4">

                    <h2 class="mb-0">
                        🌶 Masala Store
                    </h2>

                    <small>Admin Panel Login</small>

                </div>

                <div class="card-body p-4">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            {{ $errors->first() }}

                        </div>

                    @endif

                    <form method="POST"
                          action="{{ route('admin.authenticate') }}">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Email Address

                            </label>

                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="form-control"
                                   placeholder="Enter Email"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Enter Password"
                                   required>

                        </div>

                        <div class="form-check mb-3">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remember"
                                   id="remember">

                            <label class="form-check-label"
                                   for="remember">

                                Remember Me

                            </label>

                        </div>

                        <button class="btn btn-dark w-100">

                            Login

                        </button>

                    </form>

                </div>

                <div class="card-footer text-center">

                    © {{ date('Y') }} Masala Store

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>