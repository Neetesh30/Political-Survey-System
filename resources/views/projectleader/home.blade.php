@extends('layouts.projectleader.master')

@section('content')
<!-- Page Wrapper -->
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
                        {{Session::get('fail')}}
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif

                    <h3 class="page-title">Welcome  Project Manager !</h3>
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
                                <h3>{{ $total_users_count }}</h3>
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
                                <h3>{{ $total_resources_count }} </h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">
                            
                            <h6 class="text-muted">Total Resources</h6>
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
                            <span class="dash-widget-icon text-danger border-danger">
                                <i class="fe fe-money"></i>
                            </span>
                            <div class="dash-count">
                                <h3>{{ $total_users_completed_course_count }} </h3>
                            </div>
                        </div>
                        <div class="dash-widget-info">
                            <h6 class="text-muted">Completed Courses by Users</h6>
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
                        <h4 class="card-title">Users List</h4>
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
                                        <th>City</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($total_users_list as $item)
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#">00{{ $item->id }}</a>
                                            </h2>
                                        </td>
                                        <td><span class="text-danger">{{ $item->name }}</span></td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->city }}</td>
                                        <td class="text-danger"><span class="badge badge-pill bg-success inv-badge">{{ $item->status }}</span></td>
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
        <div class="row">
            <div class="col-md-12 d-flex">
                <!-- Recent Orders -->
                <div class="card card-table flex-fill">
                    <div class="card-header bg-danger text-white">
                        <h4 class="card-title">Courses List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0 datatable">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Course Name</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <h2 class="table-avatar">
                                                <a href="#">C001</a>
                                            </h2>
                                        </td>
                                        <td><span class="text-danger">Coursse AA</span></td>
                                        <td class="text-danger"><span class="badge badge-pill bg-success inv-badge">Active</span> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->
            </div>
        </div>
    </div>			
</div>
<!-- /Page Wrapper -->
@endsection
