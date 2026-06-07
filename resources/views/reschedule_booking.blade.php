@extends('layouts.rescheduling')


@section('content')
<style>
    svg {
    width: 20px;
}

.btn-success {
    background-color: #33af64;
    border: 1px solid #33af64;
}
    </style>
			<!-- Page Content -->
			<div class="content">
				<div class="container">
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
                        <div class="col-12">
                            <form action="{{ route('reschedule') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-2">
                                        <label class="col-form-label">Email Address</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="email" name='email' placeholder="Enter Email Address" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-goup">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>    
                                    </div>
                                </div>
                            </form>
                        </div>        
                    </div>
                    <hr>        
                    <div class="row">
                        <div class="col-12">
                           <!-- Recent Orders -->
                                    <div class="card card-table">
                                        <div class="card-header bg-warning text-white">
                                            <h4 class="card-title">Booked List</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-center mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Patient Name</th>
                                                            <th>Appt Time</th>
                                                            <th>Appt Date</th>
                                                            <th>Pincode</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($reschedulelist as $item)
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a>{{ $item['name'] }}</a>
                                                                </h2>
                                                            </td>
                                                            <td><span class="text-danger">{{ $item['apttime'] }}</span></td>
                                                            <td> {{ $item['aptdate'] }} </td>
                                                            <td>{{ $item['pincode'] }} </td>
                                                            <td><span class="badge badge-pill bg-success inv-badge">{{ $item['appointment_status'] }}</span></td>
                                                            <td>
                                                                <form action="{{ route('reschedule_singleid') }}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="booking_id" value="{{ $item['id'] }}">
                                                                    <button class="btn btn-sm bg-warning-light">Change Booking</button>

                                                                </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Recent Orders -->
                                    
                        </div>
                    </div>
					<!-- ... Previous HTML code ... -->
                </div>

			</div>		
			

			
@endsection