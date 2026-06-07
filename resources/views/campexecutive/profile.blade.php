@extends('layouts.campexe.master')
@section('title','Project Manager Profile')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Profile</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-header">
                        <div class="row align-items-center">
                            <div class="col-auto profile-image">
                                <a href="#">
                                    <img class="rounded-circle" alt="User Image" src="{{ asset('/assets/img/profile/')}}/{{auth()->user()->imagepath == NULL ? 'dummy-profile.png': auth()->user()->imagepath}}">
                                </a>
                            </div>
                            <div class="col ml-md-n2 profile-user-info">
                                <h4 class="user-name mb-0">{{auth()->user()->name}}</h4>
                                <h6 class="text-muted">{{auth::user()->email}}</h6>
                                <div class="user-Location"><i class="fa fa-phone"></i> {{auth::user()->phone}}</div>
                                @error('image')
                                    <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                @enderror
                                @if (Session::get('fail'))
                                    <div class="alert alert-danger">
                                        {{Session::get('fail')}}
                                    </div>
                                @endif
                                @if (Session::get('success'))
                                    <div class="alert alert-success">
                                        {{Session::get('success')}}
                                    </div>
                                @endif

                            </div>
                            <div class="col-auto profile-btn">
                                
                                <a href="#edit_image_details" data-toggle="modal" class="btn btn-primary">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-menu">
                        <ul class="nav nav-tabs nav-tabs-solid">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#per_details_tab">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#password_tab">Password</a>
                            </li>
                        </ul>
                    </div>	
                    <div class="tab-content profile-tab-cont">
                        
                        <!-- Personal Details Tab -->
                        <div class="tab-pane fade show active" id="per_details_tab">
                            
                            <!-- Personal Details -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            @foreach ($errors->all() as $message)
                                            <div class="alert alert-danger">
                                                    {{$message}}
                                                </div>
                                            @endforeach
                                            <h5 class="card-title d-flex justify-content-between">
                                                <span>Personal Details</span> 
                                                <a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>
                                            </h5>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
                                                <p class="col-sm-10">{{auth::user()->name}}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date of Birth</p>
                                                <p class="col-sm-10">{{auth::user()->dateofbirth}}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Gender</p>
                                                <p class="col-sm-10">{{auth::user()->gender}}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Email ID</p>
                                                <p class="col-sm-10">{{auth::user()->email}}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Mobile</p>
                                                <p class="col-sm-10">{{auth::user()->phone}}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0">Address</p>
                                                <p class="col-sm-10 mb-0">{{auth::user()->address}},<br>
                                                    {{auth::user()->city}}<br>
                                                    {{auth::user()->state}} - {{auth::user()->zipcode}},<br>
                                                    {{auth::user()->country}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Edit Details Modal -->
                                    <div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Personal Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.profileupdate') }}"method="POST">
                                                        @csrf
                                                        <div class="row form-row">
                                                            <div class="col-12 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Full Name</label>
                                                                    <input type="text" name="name" class="form-control" value="{{auth::user()->name}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Date of Birth</label>
                                                                    <div class="cal-icon">
                                                                        <input type="text" name="dateofbirth"  class="form-control" value="24-07-1983">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Gender</label>
                                                                    <br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input
                                                                          class="form-check-input"
                                                                          type="radio"
                                                                          name="gender"
                                                                          id="inlineRadio1"
                                                                          value="male"
                                                                        />
                                                                        <label class="form-check-label" for="inlineRadio1">male</label>
                                                                      </div>
                                                                      
                                                                      <div class="form-check form-check-inline">
                                                                        <input
                                                                          class="form-check-input"
                                                                          type="radio"
                                                                          name="gender"
                                                                          id="inlineRadio2"
                                                                          value="female"
                                                                        />
                                                                        <label class="form-check-label" for="inlineRadio2">female</label>
                                                                      </div>
                                                                </div>

                                                               
                                                            </div>
                                                          <div class="col-12 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Mobile</label>
                                                                    <input type="text" maxlength="10" class="form-control" name="phone" value="{{auth::user()->phone}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <h5 class="form-title"><span>Address</span></h5>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                <label>Address</label>
                                                                    <input type="text" name="address"  class="form-control" value="4663 Agriculture Lane">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>City</label>
                                                                    <input type="text"  name="city" class="form-control" value="Miami">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>State</label>
                                                                    <input type="text"  name="state" class="form-control" value="Florida">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Zip Code</label>
                                                                    <input type="text"  name="zipcode" class="form-control" value="22434">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="text"  name="country" class="form-control" value="United States">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Edit Details Modal -->
                                    
                                    <!-- Edit Project Manager Image  Modal -->
                                    <div class="modal fade" id="edit_image_details" aria-hidden="true" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Image </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('user.imageupdate') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row form-row">
                                                            <div class="col-12 col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Image Input</label>
                                                                    <input class="form-control" name="image" type="file">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Edit Details Modal -->
                                    
                                </div>
                                
                            
                            </div>
                            <!-- /Personal Details -->

                        </div>
                        <!-- /Personal Details Tab -->
                        
                        <!-- Change Password Tab -->
                        <div id="password_tab" class="tab-pane fade">
                        
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Change Password</h5>
                                    <div class="row">
                                        <div class="col-md-10 col-lg-6">
                                            <form action="{{route('user.changeprofileoldnewpassword')}}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input type="password" name="oldpassword" class="form-control" value="password">
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" name="newpassword" class="form-control" value="qqqqqq">
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="cpassword" class="form-control" value="qqqqqq">
                                                </div>
                                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Change Password Tab -->
                        
                    </div>
                </div>
            </div>
        
        </div>			
    </div>
    <!-- /Page Wrapper -->
@endsection