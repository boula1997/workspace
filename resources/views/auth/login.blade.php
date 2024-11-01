@extends('layouts.app')

@section('content')

<style>
    /* Custom Styles for Login Page */
    .card-header {
        background: linear-gradient(135deg, #007bff, #0056b3);
    }

    .container {
        background-color: #f7f9fc;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .img-fluid {
        object-fit: contain;
    }
</style>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="row w-100">
        <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-light">
            <img src="{{ asset(settings()->logo) }}" alt="Website Logo" class="img-fluid p-5" style="max-height: 300px;">
        </div>
        <div class="col-lg-6 col-md-8 col-12 d-flex justify-content-center">
            <div class="card shadow-sm border-0 rounded-lg w-100">
                <div class="card-header bg-primary text-white text-center rounded-top">
                    <h3 class="mb-0">{{ $title ?? '' }} {{ __('Login') }}</h3>
                </div>
                <div class="card-body p-4">
                    @isset($route)
                        <form method="POST" action="{{ route($route) }}">
                    @else
                        <form method="POST" action="{{ route('login') }}">
                    @endisset
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 position-relative">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               autocomplete="current-password">
                        <span class="toggle-password" onclick="togglePassword()" style="position: absolute; right: 10px; top: 35px; cursor: pointer;">
                            👁️
                        </span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Login') }}
                        </button>
                    </div>

                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a class="text-primary" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById("password");
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;
    }
</script>
@endsection
