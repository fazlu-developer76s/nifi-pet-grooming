@php
    $company = \App\Helpers\Global_helper::companyDetails();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8" />
<title>{{ config('app.name', 'Laravel') }}</title>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
   <!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/'.$company->favicon) }}">
<link href="assets/css/fontawesome.css" rel="stylesheet" />
<link href="assets/css/vendor.min.css" rel="stylesheet" />
<link href="assets/css/default/app.min.css" rel="stylesheet" />
</head>
<body id="body" class="auth-page" style="background:#f5f8fa url('assets/img/login.png'); background-size: cover; background-position: center center;">
 <div class="container-md">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mx-auto">
                            <div class="card">
                                <div class="card-body p-0 auth-header-box"  style="background: #f2f2f3;">
                                    <div class="text-center p-3">
                                        <a class="logo logo-admin">
                                           <img src="{{ asset('storage/'.$company->logo) }}" height="70" alt="logo" class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold text-dark font-18 ">Login</h4>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                        <form method="POST"  class="my-4" action="{{ route('login') }}">
                                        @csrf
										<div class="form-floating mb-20px">
                                        <input id="email" type="email" class="form-control fs-13px h-45px  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus  placeholder="USERNAME" />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="emailAddress" class="d-flex align-items-center py-0">Username</label>
                                        </div>

                                        <div class="form-floating mb-20px">
                                        <input  id="password" type="password" class="form-control fs-13px h-45px @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="password" class="d-flex align-items-center py-0">Password</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Remember Me') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary" name="login" type="submit">LOGIN <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div>
                                            </div>
                                            {{-- @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif --}}
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
