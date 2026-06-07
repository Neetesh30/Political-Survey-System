@extends('layouts.projectleader.master')
@section('title','Manage User List')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Booked Appointment List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User List </li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="#Add_Zoom_link_Details" data-toggle="modal" class="btn btn-primary float-right mt-2">Add Zoom Link</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Users List</h4>
                        </div>
                        <div class="card-body">
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

                            <div class="table-responsive">
                                <table class="datatable table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>Appointment Date</th>
                                            <th>Time Slot</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appointment_booked_detail as $item)
                                        <tr>
                                            @php
                                                $userData = DB::select("SELECT name,email,phone FROM users WHERE id = ?", [$item['user_id']]);
                                                if (!empty($userData)) {
                                                    echo "<td>{$userData[0]->name}</td>";
                                                } else {
                                                    echo "<td>No registration found</td>";
                                                }
                                            @endphp
                                            <td class="sorting_1">
                                                <h2 class="table-avatar">
                                                    <a href="#">{{$userData[0]->email}}</a>
                                                </h2>
                                            </td>
                                            <td>{{$userData[0]->phone}}</td>
                                            <td>{{$item['appointment_date']}}</td>
                                            <td>{{$item['appointment_time']}}</td>
                                            <td>{{$item['appointment_status']}}</td>
                                        </tr>
                                    
                                    

                                        <!-- Edit Details Modal -->
                                        <div class="modal fade" id="edit_prjmngr_details_id_{{$item['id']}}" aria-hidden="true" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Project Manager ID : #SS00{{$item['id']}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('projectleader.edituser')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <h4 class="card-title">User : {{$item['name']}}</h4>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Name</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" name="name" value="{{$item['name']}}" class="form-control">
                                                                            <input type="hidden" class="form-control" name="id" value="{{$item['id']}}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Email</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="email" name="email" value="{{$item['email']}}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Phone</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" name="phone" value="{{$item['phone']}}" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary btn-block">Update Changes</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Details Modal -->
                                        	<!-- Delete Modal -->
                                            <div class="modal fade" id="delete_prjmngr_id_{{$item['id']}}" aria-hidden="true" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <div class="form-content p-2">
                                                                <h4 class="modal-title">Delete Id : #{{$item['id']}}</h4>
                                                                <p class="mb-4">Are you sure want to delete 
                                                                    <br>
                                                                    name: {{$item['name']}}
                                                                    <br>
                                                                    Email : {{$item['email']}}
                                                                    <br>
                                                                    Role : {{ $roleNames[$item['role']] ?? 'Unknown Role' }}
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <form action="{{route('projectleader.deleteuser')}}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{$item['id']}}">
                                                                            <button type="submit" class="btn btn-primary">Confirm </button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-md-6 col">
                                                                        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Delete Modal -->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>			
    </div>
    <!-- /Page Wrapper -->

    <!-- Add Modal -->
			<div class="modal fade" id="Add_Zoom_link_Details" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Zoom Meeting  Details </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="{{ route('projectleader.updatezoomdetailappointmentuserslist') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h4 class="card-title"></h4>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Select Date And Time </label>
                                            <div class="col-lg-9">
                                                <select class="form-control" name="date_time_slot_id" required>
                                                    <option>-- Select Date And Time --</option>
                                                    @php
                                                        $appointmentData = DB::select("SELECT * FROM appointments WHERE project_manager_id = ?", [auth()->user()->id]);
                                                    @endphp
                                                
                                                    @foreach ($appointmentData as $appointmentitem)
                                                        @if ($appointmentitem->appointment_section_1_booking == 'yes')
                                                            @if ($appointmentitem->section_1_time_slot_1)
                                                                <option value="{{ $appointmentitem->appointment_section_1_date }}|{{ $appointmentitem->section_1_time_slot_1 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_1_date)->format('d-M-Y') }} - {{ $appointmentitem->section_1_time_slot_1 }}</option>
                                                            @endif
                                                            @if ($appointmentitem->section_1_time_slot_2)
                                                                <option value="{{ $appointmentitem->appointment_section_1_date }}|{{ $appointmentitem->section_1_time_slot_2 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_1_date)->format('d-M-Y') }} - {{ $appointmentitem->section_1_time_slot_2 }}</option>
                                                            @endif
                                                            @if ($appointmentitem->section_1_time_slot_3)
                                                                <option value="{{ $appointmentitem->appointment_section_1_date }}|{{ $appointmentitem->section_1_time_slot_3 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_1_date)->format('d-M-Y') }} - {{ $appointmentitem->section_1_time_slot_3 }}</option>
                                                            @endif
                                                        @endif
                                                
                                                        @if ($appointmentitem->appointment_section_2_booking == 'yes')
                                                            @if ($appointmentitem->section_2_time_slot_1)
                                                                <option value="{{ $appointmentitem->appointment_section_2_date}}|{{ $appointmentitem->section_2_time_slot_1 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_2_date)->format('d-M-Y') }} - {{ $appointmentitem->section_2_time_slot_1 }}</option>
                                                            @endif
                                                            @if ($appointmentitem->section_2_time_slot_2)
                                                                <option value="{{ $appointmentitem->appointment_section_2_date }}|{{ $appointmentitem->section_2_time_slot_2 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_2_date)->format('d-M-Y') }} - {{ $appointmentitem->section_2_time_slot_2 }}</option>
                                                            @endif
                                                            @if ($appointmentitem->section_2_time_slot_3)
                                                                <option value="{{ $appointmentitem->appointment_section_2_date }}|{{ $appointmentitem->section_2_time_slot_3 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_2_date)->format('d-M-Y') }} - {{ $appointmentitem->section_2_time_slot_3 }}</option>
                                                            @endif
                                                        @endif
                                                
                                                        @if ($appointmentitem->appointment_section_3_booking == 'yes')
                                                            @if ($appointmentitem->section_3_time_slot_1)
                                                                <option value="{{ $appointmentitem->appointment_section_3_date }}|{{ $appointmentitem->section_3_time_slot_1 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_3_date)->format('d-M-Y') }} - {{ $appointmentitem->section_3_time_slot_1 }}</option>
                                                            @endif
                                                            @if ($appointmentitem->section_3_time_slot_2)
                                                                <option value="{{ $appointmentitem->appointment_section_3_date }}|{{ $appointmentitem->section_3_time_slot_2 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_3_date)->format('d-M-Y') }} - {{ $appointmentitem->section_3_time_slot_2 }}</option>
                                                            @endif
                                                            @if ($appointmentitem->section_3_time_slot_3)
                                                                <option value="{{ $appointmentitem->appointment_section_3_date }}|{{ $appointmentitem->section_3_time_slot_3 }}">{{ \Carbon\Carbon::parse($appointmentitem->appointment_section_3_date)->format('d-M-Y') }} - {{ $appointmentitem->section_3_time_slot_3 }}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Zoom Link Details </label>
                                            <div class="col-lg-9">
                                                <textarea name="zoom_details" class="form-control" id="" placeholder="Enter Zoom Meeting Details"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
						</div>
					</div>
				</div>
			</div>
			<!-- /ADD Modal -->
@endsection