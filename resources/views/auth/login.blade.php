@extends('layouts.app')

@section('content')
    <div class="container h-100">
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="col-md-4">
{{--                <h3 class="text-danger text-bold text-xxl-center">*Please note that the system is now live. All entries should be--}}
{{--                    regarded as final.</h3>--}}
                <div class="card">
                    {{--                <div class="card-header">{{ __('Login') }}</div>--}}
                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert alert-danger">{{ session('message') }}</div>
                        @endif
                        <div>
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <img src="{{asset('assets/img/zesco_logo.png')}}" alt="ZESCO Logo"
                                     style="height: 100px;">
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-4">
                                <label class="text-uppercase" style="font-size:13px;">CCIVR Dashboard</label>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="man_no"
                                       class="col-md-12 col-form-label text-md-left">{{ __('Man Number') }}</label>
                                <div class="col-md-12">
                                    <input id="man_no" type="text"
                                           class="form-control @error('man_no') is-invalid @enderror" name="man_no"
                                           value="{{ old('man_no') }}" required autocomplete="man_no" autofocus>
                                    @error('man_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="password"
                                       class="col-md-12 col-form-label text-md-left">{{ __('Password') }}</label>
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                        <div id="togglePassword" title="Click here to make password visible/invisible"
                                             class="input-group-append toggle_password">
                                            <i id="showHidePasswordIcon" class="fa fa-eye"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success btn-block">
                                        <i class="fa fa-paper-plane"></i>
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-12 pl-0">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password ?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_script')
    <script>
        function toggleShowPassword(event) {
            let $password = document.querySelector("#password");
            let $showPasswordIcon = document.querySelector("#showHidePasswordIcon");
            let attributes = $password.attributes;
            if (attributes.hasOwnProperty('type') && attributes['type'].nodeValue === 'password') {
                $password.setAttribute('type', 'text');
                $showPasswordIcon.classList.add('fa-eye-slash');
                $showPasswordIcon.classList.remove('fa-eye');
            } else {
                $password.setAttribute('type', 'password');
                $showPasswordIcon.classList.add('fa-eye');
                $showPasswordIcon.classList.remove('fa-eye-slash');
            }
            return;
        }

        window.onload = function () {
            let togglePassword = document.querySelector("#togglePassword");
            togglePassword.addEventListener('click', function (event) {
                toggleShowPassword(event);
            })
        }
    </script>
@endpush
