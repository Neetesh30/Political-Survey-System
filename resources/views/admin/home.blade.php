@extends('layouts.admin.master')
@section('content')
<div class="page-wrapper">
			
    <div class="content container-fluid">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                     @error('image')
                    <div class="alert alert-warning">
                        {{$message}}
                    </div>
                @enderror
                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {!! Session::get('fail')  !!}
                    </div>
                @endif
                @if (Session::get('danger'))
                    <div class="alert alert-danger">
                        {!! Session::get('danger')  !!}
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {!! Session::get('success')  !!}
                    </div>
                @endif

                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger">
                            {{$message}}
                        </div>
                @endforeach

                    <h3 class="page-title">Welcome  Admin !</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">{{auth()->user()->name}} | Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-primary border-primary">
                                <i class="fe fe-users"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_new_doctor_count }}</h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">
                            <h6 class="text-muted">Total Registered Users </h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-success">
                                <i class="fe fe-credit-card"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_approved_doctor_count }} </h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">
                            <h6 class="text-muted">Approved Users</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-success w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-warning">
                                <i class="fe fe-credit-card"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_verification_doctor_count }} </h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">
                            <h6 class="text-muted">Ongoing Verification Of Users</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-warning w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dash-widget-header">
                            <span class="dash-widget-icon text-danger border-danger">
                                <i class="fe fe-money"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_rejected_doctor_count }} </h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">
                            <h6 class="text-muted">Rejected Users</h6>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-danger w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 d-flex">
                <!-- Recent Orders -->
                <div class="card card-table flex-fill">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title">Registered Users List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Doctor Name</th>
                                        <th>Doctor Email</th>
                                        <th>Doctor Address</th>
                                        <th>Doctor City</th>
                                        <th>Doctor State</th>
                                        <th>Doctor Pincode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total_new_doctor_list as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#">{{ $item->id  }}</a>
                                            </h2>
                                        </td>
                                        <td>{{ $item->name  }}</td>
                                        <td>{{ $item->email  }}</td>
                                        <td>{{ $item->phone  }}</td>
                                        <td>{{ $item->doctor_name }}</td>
                                        <td><span class="text-danger">{{ $item->doctor_email }}</span></td>
                                        <td>
                                            <div style="width: 200px; overflow-x: auto;">
                                                {{ $item->doctor_address }}  
                                            </div>
                                        </td>
                                        <td>{{ $item->doctor_city }}</td>
                                        <td>{{ $item->doctor_state }}</td>
                                        <td>{{ $item->doctor_pincode }}</td>
                                        <td>
                                            <div class="actions">
                                                <form action="{{ route('admin.changenewdoctorregstatus') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id  }}">
                                                    <button type="submit" class="btn btn-sm bg-warning-light "><i class="fe fe-pencil mr-1"></i>Send for Verification</button>
                                                </form>
                                            </div>
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


      

        {{-- Ongoing List --}}
            <div class="row">
                <div class="col-md-12 d-flex">
                    <!-- Recent Orders -->
                    <div class="card card-table flex-fill">
                        <div class="card-header bg-warning text-white">
                            <h4 class="card-title">Ongoing Users Verification List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Doctor Name</th>
                                            <th>Doctor Email</th>
                                            <th>Doctor Address</th>
                                            <th>Doctor City</th>
                                            <th>Doctor State</th>
                                            <th>Doctor Pincode</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($total_verification_doctor_list as $item)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="#">{{ $item->id  }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $item->name  }}</td>
                                            <td>{{ $item->email  }}</td>
                                            <td>{{ $item->phone  }}</td>
                                            <td>{{ $item->doctor_name }}</td>
                                            <td><span class="text-danger">{{ $item->doctor_email }}</span></td>
                                            <td>
                                                <div style="width: 200px; overflow-x: auto;">
                                                    {{ $item->doctor_address }}  
                                                </div>
                                            </td>
                                            <td>{{ $item->doctor_city }}</td>
                                            <td>{{ $item->doctor_state }}</td>
                                            <td>{{ $item->doctor_pincode }}</td>
                                            <td>
                                                <a class="btn btn-sm bg-success-light" data-toggle="modal" href="#approve_regdoc_id_{{$item['id']}}">
                                                    <i class="fe fe-user-plus"></i> Approve
                                                </a>

                                                <a class="btn btn-sm bg-danger-light" data-toggle="modal" href="#reject_regdoc_id_{{$item['id']}}">
                                                    <i class="fe fe-user-minus"></i> Reject
                                                </a>
                                            </td>

                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approve_regdoc_id_{{$item['id']}}" aria-hidden="true" role="dialog">
                                                <div class="modal-dialog  modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-success">
                                                            <h4 class="modal-title ">Accept User Id : #{{$item['id']}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-content p-2">
                                                                <p class="mb-4">Are you sure want to Approve Doctor 
                                                                    <br>
                                                                    Doctor Name: {{$item['doctor_name']}}
                                                                    <br>
                                                                    Doctor Email : {{$item['doctor_email']}}
                                                                    <br>
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <form action="{{ route('admin.doctorapprovestatus') }}" method="post">
                                                                            @csrf
                                                                            <input type="hidden" name="id" value="{{$item['id']}}">
                                                                            <button type="submit" class="btn btn-success">Confirm </button>
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
                                            <!-- /Approve Modal -->

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="reject_regdoc_id_{{$item['id']}}" aria-hidden="true" role="dialog">
                                                <div class="modal-dialog  modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger">
                                                            <h4 class="modal-title ">Reject User Id : #{{$item['id']}}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-content p-2">
                                                                <form action="{{ route('admin.doctorrejectstatus') }}" method="post">
                                                                <p class="mb-4">Are you sure want to Reject Doctor 
                                                                    <br>
                                                                    Doctor Name: {{$item['doctor_name']}}
                                                                    <br>
                                                                    Doctor Email : {{$item['doctor_email']}}
                                                                    <br>
                                                                </p>
                                                                <div class="row mb-2">
                                                                    <div class="col-md-12">
                                                                        <label for="">Reject Remarks</label>
                                                                        <input type="text" class="form-control" placeholder="Enter reject remarks" name="remarks" id="" >
                                                                        <small class="text-dark">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        @csrf
                                                                        <input type="hidden" name="id" value="{{$item['id']}}">
                                                                            <button type="submit" class="btn btn-warning">Confirm </button>
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
                                            <!-- /Reject Modal -->
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
        {{-- Ongoing List --}}

          {{-- Approved List --}}
            <div class="row">
                <div class="col-md-12 d-flex">
                    <!-- Recent Orders -->
                    <div class="card card-table flex-fill">
                        <div class="card-header bg-success text-white">
                            <h4 class="card-title">Approved Users List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Doctor Name</th>
                                            <th>Doctor Email</th>
                                            <th>Doctor Address</th>
                                            <th>Doctor City</th>
                                            <th>Doctor State</th>
                                            <th>Doctor Pincode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($total_approved_doctor_list as $item)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="#">{{ $item->id  }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $item->name  }}</td>
                                            <td>{{ $item->email  }}</td>
                                            <td>{{ $item->phone  }}</td>
                                            <td>{{ $item->doctor_name }}</td>
                                            <td><span class="text-danger">{{ $item->doctor_email }}</span></td>
                                            <td>
                                                <div style="width: 200px; overflow-x: auto;">
                                                    {{ $item->doctor_address }}  
                                                </div>
                                            </td>
                                            <td>{{ $item->doctor_city }}</td>
                                            <td>{{ $item->doctor_state }}</td>
                                            <td>{{ $item->doctor_pincode }}</td>
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
        {{-- Approved List --}}

        {{-- Rejected List --}}
            <div class="row">
                <div class="col-md-12 d-flex">
                    <!-- Recent Orders -->
                    <div class="card card-table flex-fill">
                        <div class="card-header bg-danger text-white">
                            <h4 class="card-title">Rejected Users List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-center mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Doctor Name</th>
                                            <th>Doctor Email</th>
                                            <th>Doctor Address</th>
                                            <th>Doctor City</th>
                                            <th>Doctor State</th>
                                            <th>Doctor Pincode</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($total_rejected_doctor_list as $item)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="#">{{ $item->id  }}</a>
                                                </h2>
                                            </td>
                                            <td>{{ $item->name  }}</td>
                                            <td>{{ $item->email  }}</td>
                                            <td>{{ $item->phone  }}</td>
                                            <td>{{ $item->doctor_name }}</td>
                                            <td><span class="text-danger">{{ $item->doctor_email }}</span></td>
                                            <td>
                                                <div style="width: 200px; overflow-x: auto;">
                                                    {{ $item->doctor_address }}  
                                                </div>
                                            </td>
                                            <td>{{ $item->doctor_city }}</td>
                                            <td>{{ $item->doctor_state }}</td>
                                            <td>{{ $item->doctor_pincode }} </td>
                                            <td>{{ $item->remarks }} </td>
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
        {{-- Approved List --}}
    


    </div>			
</div>
<!-- /Page Wrapper -->
@endsection
