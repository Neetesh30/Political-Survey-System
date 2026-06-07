@extends('layouts.admin.master')
@section('title','Admin Profile')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Project Manager List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Project Manager </li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="#Add_ProjectMangrDetails" data-toggle="modal" class="btn btn-primary float-right mt-2">Add</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Project Manager List</h4>
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
                                            <th>Status</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($PrjmngrList as $item)
                                        <tr>
                                            <td>{{$item['name']}}</td>
                                            <td>{{$item['email']}}</td>
                                            <td>{{$item['phone']}}</td>
                                            <td>
                                                <form id="statusForm_{{$item['id']}}" action="{{route('admin.editstatus')}}" method="POST">
                                                    @csrf
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_{{$item['id']}}"  class="check" {{ $item['status'] == 'active' ? 'checked' : '' }} >
                                                    <label  for="status_{{$item['id']}}" class="checktoggle">checkbox</label>
                                                </div>
                                                <input type="hidden" class="form-control" name="id" value="{{$item['id']}}">

                                                </form>

                                                <script>
                                                    document.getElementById('status_{{$item['id']}}').addEventListener('change', function () {
                                                        document.getElementById('statusForm_{{$item['id']}}').submit();
                                                    });
                                                </script>
                                            </td>

                                            <td>
                                                <div class="actions">
                                                    <a class="btn btn-sm bg-success-light" data-toggle="modal" href="#edit_prjmngr_details_id_{{$item['id']}}">
                                                        <i class="fe fe-pencil"></i> Edit
                                                    </a>
                                                    <a data-toggle="modal" href="#delete_prjmngr_id_{{$item['id']}}" class="btn btn-sm bg-danger-light">
                                                        <i class="fe fe-trash"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
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
                                                        <form action="{{route('admin.editprjmanager')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <h4 class="card-title">Project Manager : {{$item['name']}} </h4>
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
                                                                <p class="mb-4">Are you sure want to delete?</p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <form action="{{route('admin.deleteprjmanager')}}" method="post">
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
			<div class="modal fade" id="Add_ProjectMangrDetails" aria-hidden="true" role="dialog">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Add Project Manager</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="{{ route('admin.addprjmanager') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h4 class="card-title">Personal Details</h4>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Name</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Email</label>
                                            <div class="col-lg-9">
                                                <input type="email" name="email" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Phone</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="phone" class="form-control">
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