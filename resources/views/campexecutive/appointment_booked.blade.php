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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header" id="ajaxalertcontainer">
                            <h4 class="card-title">Booked Appointment Details</h4>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Appointment Date :</label>
                                            <div class="col-lg-6">
                                                <span class="text-danger"> @if ($registration_detail) {{ $registration_detail->appointment_date }}  @endif  </span> 
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot :</label>
                                            <div class="col-lg-6">
                                                <span class="text-danger"> @if ($registration_detail) {{ $registration_detail->appointment_time }} @endif </span>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Meeting Details  :</label>
                                            <div class="col-lg-6">
                                                @if($registration_detail->zoom_details != NULL)
                                                    <div class="alert alert-primary"> @if ($registration_detail) {!!  $registration_detail->zoom_details !!} @endif</div>
                                                @else
                                                    <div class="alert alert-warning"> Meeting Details not scheduled yet , please check next time</div>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>			
    </div>
    <!-- /Page Wrapper -->

@endsection