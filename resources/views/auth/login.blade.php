@extends('layouts.app')

@section('content')

                     @if (Session::get('danger'))
                    <div class="alert alert-danger">
                        {{ Session::get('danger') }}
                    </div>
                    @endif
                    <!--@if (Session::get('success'))-->
                    <!--<div class="alert alert-success">-->
                    <!--    {{ Session::get('success') }}-->
                    <!--</div>-->
                    <!--@endif-->

                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger">
                                {{$message}}
                            </div>
                    @endforeach

            
                    <form method="POST" class="" id="login-form-container" action="{{ route('login') }} ">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Login') }}
                                </button>

                                {{-- <div class="login-or">
                                    <span class="or-line"></span>
                                    <span class="span-or">or</span>
                                </div> --}}

                                <div class="row form-row social-login ">
                                    <div class="col-12">
                                        {{-- <a href="{{ route('login.mobile') }}" class="btn btn-facebook btn-block"><i class="fas fa-mobile-alt mr-1"></i>Login with Mobile</a> --}}
                                    </div>
                                </div>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                                
                            </div>
                        </div>
                    </form>
                 
@endsection
