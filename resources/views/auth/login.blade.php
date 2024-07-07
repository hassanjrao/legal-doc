@extends('layouts.front')

@section('page-title', 'Login')

@section('content')
    <div class="container-lg mt-4">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="card custom-card">
                        <div class="card-body p-5">
                            <p class="h5 fw-semibold mb-2 text-center">{{ __('Login') }}</p>
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="email" class="form-label text-default">{{ __('Email Address') }}</label>
                                    <input type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        id="email" placeholder="Email" value="{{ old('email') }}" required
                                        autocomplete="email" autofocus name="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-2">
                                    @if (Route::has('password.request'))
                                    <label for="password" class="form-label text-default d-block">{{ __('Password') }}
                                        <a href="{{ route('password.request') }}"
                                         class="float-end text-danger">
                                            Forget password?
                                        </a>
                                    </label>
                                    @endif
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control form-control-lg" id="password"
                                            placeholder="password" required>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                                id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                {{ __('Remember Me') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <button type="submit" class="btn btn-lg btn-primary">{{ __('Login') }}</button>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-muted mt-3">Dont have an account? <a href="{{ route('register') }}"
                                        class="text-primary"> {{ __('Register') }}</a></p>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
