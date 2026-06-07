@extends('layouts.campexe.master')

@section('title','Appointment Details ')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col">
                        <h3 class="page-title">Appointemnt Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Appointemnt Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-md-12">
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
                    <div class="profile-header">
                        <div class="row align-items-center">
                            @if($single_appointment_detail->isNotEmpty())
                                <div class="col ml-md-n2 profile-user-info">
                                    <h2 class="user-name mb-0 text-danger">Client  Details</h2>
                                    <h4 class="user-name mb-0"><i class="fa fa-user mr-1"></i> Name : {{ $single_appointment_detail->first()->name }}</h4>
                                    <h6 class="text-muted"><i class="fa fa-inbox mr-1"></i>Email : {{$single_appointment_detail->first()->email}}</h6>
                                    <div class="user-Location"><i class="fa fa-phone mr-1"></i>Phone :  {{$single_appointment_detail->first()->phone}}</div>
                                </div>
                                <div class="col-auto profile-btn">
                                    Agent Action  : 

                                   @if ($single_appointment_detail->first()->appointment_status == 'active')
                                   <button class="btn btn-sm bg-success-light" data-toggle="modal" data-target="#accept_booking_Modal" >
                                    <i class="fe fe-pencil"></i> Start Demo Time </button>
                                    <form action="{{ route('user.resendotpfordemostart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="booked_apointment_id" value="{{ $single_appointment_detail->first()->id }}">

                                        <button class="btn btn-sm bg-warning-light">
                                            <i class="fe fe-pencil"></i> Resend Otp To Client  </button>
                                    </form>
                                    {{-- <button class="btn btn-sm bg-warning-light" data-toggle="modal" data-target="#reject_booking_Modal">
                                    <i class="fe fe-pencil"></i> Reject </button> --}}
                                   @else
                                   <button class="btn btn-sm bg-danger-light" data-toggle="modal" data-target="#end_demo_booking_Modal" >
                                    <i class="fe fe-pencil"></i> End Demo Time </button>
                                   @endif  
                                    
                                </div>

                                <!--Accept/Start Demo  Modal -->
                                <div class="modal fade" id="accept_booking_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success">
                                                <h5 class="modal-title" id="exampleModalLabel">Book Appointment - {{ $single_appointment_detail->first()->aptday }} | {{ $single_appointment_detail->first()->aptdate }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Your appointment form goes here -->
                                                <form class="aptForm" action="{{ route('user.ongoingbooking') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <!-- Add your form fields here -->
                                                            <div class="form-group">
                                                                <label for="name">Name:  {{ $single_appointment_detail->first()->name }}</label>
                                                                <input type="hidden" name="id" value=" {{ $single_appointment_detail->first()->id }} ">
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="name">Mobile: {{ $single_appointment_detail->first()->phone }}</label>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="email">Email: {{ $single_appointment_detail->first()->email }}</label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="time">Appointment Time: <span class="text-danger"> {{ $single_appointment_detail->first()->apttime }}</span></label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="time">Current Apoointment status : <span class="text-danger"> {{ $single_appointment_detail->first()->appointment_status }}</span></label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name">Enter  OTP to start demo time: </label>
                                                                <input type="text" name="verify_otp" placeholder="Please Enter 6 DIGIT OTP" class="form-control" required>
                                                                <small>Enter 6 DIGIT OTP send to client at the time of booking</small>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name">Enter Device Serial Code: </label>
                                                                <input type="text" name="device_serial_code" placeholder="Please Enter Device Serial Code " class="form-control" required>
                                                                <small>Enter device serial code used by client </small>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-block btn-success">click here to start appointment </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--Complete / End Demo Modal -->
                                <div class="modal fade" id="end_demo_booking_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <h5 class="modal-title text-white" id="exampleModalLabel">Book Appointment - {{ $single_appointment_detail->first()->aptday }} | {{ $single_appointment_detail->first()->aptdate }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Your appointment form goes here -->
                                                <form class="aptForm" action="{{ route('user.completedbooking') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <!-- Add your form fields here -->
                                                            <div class="form-group">
                                                                <label for="name">Name:  {{ $single_appointment_detail->first()->name }}</label>
                                                                <input type="hidden" name="id" value=" {{ $single_appointment_detail->first()->id }} ">
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="name">Mobile: {{ $single_appointment_detail->first()->phone }}</label>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="email">Email: {{ $single_appointment_detail->first()->email }}</label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="time">Appointment Time: <span class="text-danger"> {{ $single_appointment_detail->first()->apttime }}</span></label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="time">Current Appointment status : <span class="text-danger"> {{ $single_appointment_detail->first()->appointment_status }}</span></label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="time">Appointment Start Time : <span class="text-danger"> {{ $single_appointment_detail->first()->start_time_of_apt }}</span></label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label for="time">Device Id  : <span class="text-danger"> {{ $single_appointment_detail->first()->device_serial_no }}</span></label>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <button type="submit" class="btn btn-block btn-success">click here to complete appointment </button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button class="btn btn-sm bg-warning text-white" type="button" data-toggle="modal" data-target="#reject_booking_Modal">Reject / Not Completed</button>
                                                        </div>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!--Reject  Modal -->
                                <div class="modal fade" id="reject_booking_Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning">
                                                <h5 class="modal-title" id="exampleModalLabel">Book Appointment - {{ $single_appointment_detail->first()->aptday }} | {{ $single_appointment_detail->first()->aptdate }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Your appointment form goes here -->
                                                <form class="aptForm" action="{{ route('user.rejectbooking') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <!-- Add your form fields here -->
                                                            <div class="form-group">
                                                                <label for="name">Name:  {{ $single_appointment_detail->first()->name }}</label>
                                                                <input type="hidden" name="id" value=" {{ $single_appointment_detail->first()->id }} ">
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="name">Mobile: {{ $single_appointment_detail->first()->phone }}</label>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="email">Email: {{ $single_appointment_detail->first()->email }}</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="time">Appointment Time: <span class="text-danger"> {{ $single_appointment_detail->first()->apttime }} </span></label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="time">Appointment Start Time : <span class="text-danger"> {{ $single_appointment_detail->first()->start_time_of_apt }}</span></label>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="time">Device Id  : <span class="text-danger"> {{ $single_appointment_detail->first()->device_serial_no }}</span></label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name">Reject Reasons: </label>
                                                                <input type="text" name="remarks" placeholder="please write reasons to reject appointment" class="form-control" required>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                    
                                                    <button type="submit" class="btn btn-block btn-warning">Click here to reject Appointment </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @else
                            <div class="col ml-md-n2 profile-user-info">
                                <p>No appointment found with the given ID</p>
                            </div>
                            @endif
                        </div>
                    </div>
                   
                    <div class="tab-content profile-tab-cont">
                        
                        @if($single_appointment_detail->isNotEmpty())
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
                                                <span>Appointment Details</span> 
                                            </h5>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Time </p>
                                                <p class="col-sm-10"><span class="text-danger">{{ $single_appointment_detail->first()->apttime }}</span></p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Date</p>
                                                <p class="col-sm-10">{{ $single_appointment_detail->first()->aptdate }}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Day</p>
                                                <p class="col-sm-10">{{ $single_appointment_detail->first()->aptday }}</p>
                                            </div>
                                          
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Status</p>
                                                <p class="col-sm-10">
                                                    <span class="badge badge-pill bg-success inv-badge">{{ $single_appointment_detail->first()->appointment_status }}</span>
                                                </p>
                                            </div>
                                            <hr>

                                            <h5 class="card-title d-flex justify-content-between">
                                                <span>Address Details</span> 
                                            </h5>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Address</p>
                                                <p class="col-sm-10">{{ $single_appointment_detail->first()->address }}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">City</p>
                                                <p class="col-sm-10">{{ $single_appointment_detail->first()->city }}</p>
                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0">State</p>
                                                <p class="col-sm-10">{{ $single_appointment_detail->first()->state }}</p>

                                            </div>
                                            <div class="row">
                                                <p class="col-sm-2 text-muted text-sm-right mb-0">Pincode</p>
                                                <p class="col-sm-10">{{ $single_appointment_detail->first()->pincode }}</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Personal Details -->
                        </div>
                        <!-- /Personal Details Tab -->


                            @else
                            
                        @endif

                        
                    </div>
                </div>
            </div>
        
        </div>			
    </div>
    <!-- /Page Wrapper -->
@endsection