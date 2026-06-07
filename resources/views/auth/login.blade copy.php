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

          
                    <form method="POST" id="login-form-container" action="{{ route('login') }}">
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

                                <div class="login-or">
                                    <span class="or-line"></span>
                                    <span class="span-or">or</span>
                                </div>

                                <div class="row form-row social-login ">
                                    <div class="col-12">
                                        <a href="{{ route('login.mobile') }}" class="btn btn-facebook btn-block"><i class="fas fa-mobile-alt mr-1"></i>Login with Mobile</a>
                                    </div>
                                </div>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                
                             <div class="text-center dont-have"> <a href="#Add_ProjectMangrDetails" data-toggle="modal" >Are you a New user ?</a></div>

                            </div>
                        </div>
                    </form>
                    
                        <!-- Add Modal -->
    <div class="modal fade" id="Add_ProjectMangrDetails" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New User Registration </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('newdoctorregistration') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Full Name</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="username" class="form-control" >
                                        <small class="text-dark">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Email</label>
                                    <div class="col-lg-9">
                                        <input type="email" name="useremail" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Phone</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="userphone" class="form-control" >
                                        <small class="text-dark">Only numbers are allowed.</small>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Doctor Full Name</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="doctor_name" class="form-control" >
                                        <small class="text-dark">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Doctor Email Id</label>
                                    <div class="col-lg-9">
                                        <input type="email" name="doctor_email" class="form-control" >
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Doctor Location Address</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="doctor_address" class="form-control" >
                                        <small class="text-dark">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Doctor Location City</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="doctor_city" class="form-control" >
                                        <small class="text-dark">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Doctor Location State</label>
                                    <div class="col-lg-9">
                                        <select name="doctor_state" class="form-control">
                                            <option value="">Select State</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Puducherry">Puducherry</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Doctor Location Pincode</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="doctor_pincode" class="form-control" >
                                        <small class="text-dark">Only numbers are allowed.</small>

                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /ADD Modal -->
                 
@endsection
