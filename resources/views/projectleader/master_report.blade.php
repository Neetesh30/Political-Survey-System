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
                    <h3 class="page-title">Master Report</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">New Appointment Booked List </li>
                    </ul>

                </div>
            </div>
        </div>
        <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Master Report</h4>
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

                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <!-- Recent Orders -->
                                    <div class="card card-table flex-fill">
                                        <div class="card-header bg-primary text-white">
                                            <h4 class="card-title">Quiz Report </h4>
                                            <a href="{{ route('projectleader.report.download.csv') }}" class="btn btn-primary text-right">Download CSV Report</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-center mb-0 datatable">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Quiz Name</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>City</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($quizmasterlist as $item)
                                                        <tr>
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <a href="#">00{{ $item->id }}</a>
                                                                </h2>
                                                            </td>
                                                             @php
                                                                $quizData = DB::select("SELECT course_name FROM courses WHERE id = ?", [$item->course_id]);
                                                            @endphp
                                                               @if (!empty($quizData))
                                                                    <td>{{ $quizData[0]->course_name }}</td>
                                                                @else
                                                                    <td>No quiz registration found</td>
                                                                @endif
                                                             
                                                            @php
                                                                $usersData = DB::select("SELECT name,email,phone,city FROM users WHERE id = ?", [$item->user_id]);
                                                            @endphp
                                                               @if (!empty($usersData))
                                                                    <td>{{ $usersData[0]->name }}</td>
                                                                    <td>{{ $usersData[0]->email }}</td>
                                                                    <td>{{ $usersData[0]->phone }}</td>
                                                                    <td>{{ $usersData[0]->city }}</td>
                                                                @else
                                                                    <td>No quiz registration found</td>
                                                                @endif

                                                             {{-- @php
                                                                    $courseData = DB::select("SELECT course_id FROM courseregistrations WHERE user_id = ?", [$item['id']]);
                                                                    if (!empty($courseData)) {
                                                                        $course_id = $courseData[0]->course_id;
                                                                        $coursedetails = DB::select("SELECT course_name FROM courses WHERE id = ?", [$course_id]);
                                                                        if (!empty($coursedetails)) {
                                                                            $course_name = $coursedetails[0]->course_name;
                                                                            echo "<td>$course_name</td>";
                                                                        } else {
                                                                            echo "<td>No quiz found</td>";
                                                                        }
                                                                    } else {
                                                                        echo "<td>No quiz registration found</td>";
                                                                    }
                                                                @endphp --}}
                                                            <td class="text-danger">
                                                                <span class="badge badge-pill {{ $item->course_status == 'active' ? 'bg-warning' : 'bg-success' }} inv-badge">
                                                                    {{ $item->course_status }}
                                                                </span>
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
                        </div>
                    </div>
                </div>
            </div>
        
        </div>			
    </div>
    <!-- /Page Wrapper -->

 @endsection