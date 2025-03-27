@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-danger">{{ session('message') }}</div>
                        @endif
                        <div>
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <img src="{{asset('assets/img/zesco_logo.png')}}" alt="ZESCO Logo"
                                     style="height: 100px;">
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-5">
                                <label class="text-uppercase" style="font-size:15px;">CCIVR Dashboard</label>

                            </div>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="man_no"
                                       class="col-md-4 col-form-label text-md-end">{{ __('MAN Number') }}</label>
                                <div class="col-md-6">
                                    <input id="man_no" type="text"
                                           class="form-control @error('man_no') is-invalid @enderror" name="man_no"
                                           value="{{ old('man_no') }}" required autocomplete="name" autofocus>

                                    @error('man_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-block btn-success">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <p class="pl-2 ml-1"><a class="btn btn-link" href="{{ route('login') }}">
                                            Already have an account? Click here to Login </a></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
