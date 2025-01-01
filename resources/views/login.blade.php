<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    @include('layouts.css') <!-- Pastikan CSS bootstrap sudah disertakan -->
</head>

<body class="h-100" style="background-color: #f7f7f7;">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    <h4 class="text-center mb-4">Login</h4>
                    <hr>
                    <!-- Form Login -->
                    <form action="{{ url('login') }}" method="POST">
                        @csrf
                        <!-- Success or Fail Messages -->
                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif
                        @if (Session::has('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                        @endif

                        <!-- Email Input -->
                        <div class="form-group mb-3">
                            <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email Address" required>
                        </div>

                        <!-- Password Input -->
                        <div class="form-group mb-3">
                            <input type="password" class="form-control form-control-lg" name="pwd" id="pwd" placeholder="Password" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Sign In</button>
                    </form>

                    <!-- Forgot Password Link -->
                    <div class="text-center mt-3">
                        <a href="{{ url('password/reset') }}" class="text-muted">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.js') <!-- Pastikan JS bootstrap sudah disertakan -->
</body>
@include('layouts.footer')
</html>
