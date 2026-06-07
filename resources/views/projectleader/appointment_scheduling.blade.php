@extends('layouts.projectleader.master')
@section('title','Manage Quiz Resources')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                @if (Session::get('danger'))
                    <div class="alert alert-danger">
                        {!! Session::get('danger') !!}
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {!! Session::get('success') !!}
                    </div>
                @endif
               
                @foreach ($errors->all() as $message)
                        <div class="alert alert-danger">
                                {{$message}}
                            </div>
                @endforeach

                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Manage Appointnment </h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User List </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header" id="ajaxalertcontainer">
                            <h4 class="card-title">Schedule Appointment 1</h4>
                        </div>
                        <div class="card-body">
                                    <form id="appointmentForm" action="{{ route('projectleader.store-or-update-appointment', $appointment_detail->id ?? '') }}" method="post">

                                        @csrf
                                  
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Appointment Date</label>
                                            <div class="col-lg-6">
                                                <input type="date" name="appointment_section_1_date" value="{{ old('appointment_section_1_date') }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 1</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_1_time_slot_1" value="{{ old('section_1_time_slot_1') }}"  class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 2</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_1_time_slot_2" value="{{ old('section_1_time_slot_2') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 3</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_1_time_slot_3" value="{{ old('section_1_time_slot_3') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                            @if (!empty($appointment_detail->appointment_section_1_booking) && $appointment_detail->appointment_section_1_booking == 'yes')
                            <hr>
                                <div class="text-danger">Booked Details</div>
                                <div class="text-black">Date : <span class="text-primary">{{$appointment_detail->appointment_section_1_date}}</span> </div>
                                    @if ($appointment_detail->section_1_time_slot_1)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_1_time_slot_1}}</span> </div>
                                    @endif
                                    @if ($appointment_detail->section_1_time_slot_2)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_1_time_slot_2}}</span> </div>
                                    @endif
                                    @if ($appointment_detail->section_1_time_slot_2)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_1_time_slot_3}}</span> </div>
                                    @endif
                                
                            @endif



                           
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header" id="ajaxalertcontainer">
                            <h4 class="card-title">Schedule Appointment 2</h4>
                        </div>
                        <div class="card-body">
                                <form id="appointmentForm" action="{{ route('projectleader.store-or-update-appointment', $appointment_detail->id ?? '') }}" method="post">
                                    @csrf
                                 
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Appointment Date</label>
                                            <div class="col-lg-6">
                                                <input type="date" name="appointment_section_2_date" value="{{ old('appointment_section_2_date') }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 1</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_2_time_slot_1" value="{{ old('section_2_time_slot_1') }}"  class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 2</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_2_time_slot_2" value="{{ old('section_2_time_slot_2') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 3</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_2_time_slot_3" value="{{ old('section_2_time_slot_3') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                            @if (!empty($appointment_detail->appointment_section_2_booking) && $appointment_detail->appointment_section_2_booking == 'yes')
                                <hr>
                                <div class="text-danger">Booked Details</div>
                                <div class="text-black">Date : <span class="text-primary">{{$appointment_detail->appointment_section_2_date}}</span> </div>
                                    @if ($appointment_detail->section_2_time_slot_1)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_2_time_slot_1}}</span> </div>
                                    @endif
                                    @if ($appointment_detail->section_2_time_slot_2)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_2_time_slot_2}}</span> </div>
                                    @endif
                                    @if ($appointment_detail->section_2_time_slot_3)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_2_time_slot_3}}</span> </div>
                                    @endif
                                
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header" id="ajaxalertcontainer">
                            <h4 class="card-title">Schedule Appointment 3</h4>
                        </div>
                        <div class="card-body">
                            <form id="appointmentForm" action="{{ route('projectleader.store-or-update-appointment', $appointment_detail->id ?? '') }}" method="post">
                                    @csrf
                                    
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Appointment Date</label>
                                            <div class="col-lg-6">
                                                <input type="date" name="appointment_section_3_date" value="{{ old('appointment_section_3_date') }}" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 1</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_3_time_slot_1" value="{{ old('section_3_time_slot_1') }}"  class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 2</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_3_time_slot_2" value="{{ old('section_3_time_slot_2') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label">Time Slot 3</label>
                                            <div class="col-lg-6">
                                                <input type="time" name="section_3_time_slot_3" value="{{ old('section_3_time_slot_2') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                </div>
                            </form>

                            @if (!empty($appointment_detail->appointment_section_3_booking) && $appointment_detail->appointment_section_3_booking == 'yes')

                                <hr>
                                <div class="text-danger">Booked Details</div>
                                <div class="text-black">Date : <span class="text-primary">{{$appointment_detail->appointment_section_3_date}}</span> </div>
                                    @if ($appointment_detail->section_3_time_slot_1)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_3_time_slot_1}}</span> </div>
                                    @endif
                                    @if ($appointment_detail->section_3_time_slot_2)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_3_time_slot_2}}</span> </div>
                                    @endif
                                    @if ($appointment_detail->section_3_time_slot_3)
                                        <div class="text-black">Time : <span class="text-primary">{{$appointment_detail->section_3_time_slot_3}}</span> </div>
                                    @endif
                            @endif
                           
                        </div>
                    </div>
                </div>
            </div>
            
        </div>			
    </div>
    <!-- /Page Wrapper -->

@endsection