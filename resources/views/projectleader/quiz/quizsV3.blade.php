@extends('layouts.projectleader.master')
@section('title','Manage Courses MCQ List')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Manage Courses / MCQ List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User List </li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="#Add_ProjectMangrDetails" data-toggle="modal" class="btn btn-primary float-right mt-2">Add New Course</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Course List</h4>
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
                                            <th>Id </th>
                                            <th>Course Name</th>
                                            <th>From Name</th>
                                            <th>From Email</th>
                                            <th>From Phone</th>
                                            <th>Quiz Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quizdatalist as $item)
                                        <tr>
                                            <td class="text-danger">#Q00{{$item['id']}}</td>
                                            <td class="text-danger">{{$item['course_name']}}</td>
                                            <td>{{$item['updatedby_user_name']}}</td>
                                            <td>{{$item['updatedby_user_email']}}</td>
                                            <td>{{$item['updatedby_user_phone']}}</td>
                                            <td>{{$item['course_status']}}</td>
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
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Quiz ID : #Q00{{$item['id']}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                       
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
                                                                <h4 class="modal-title">Delete Id : #Q00{{$item['id']}}</h4>
                                                                <p class="mb-4">Are you sure want to delete 
                                                                    <br>
                                                                    Quiz name: {{$item['quiz_name']}}
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <form action="{{route('projectleader.deletequiz')}}" method="post">
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
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content ">
						<div class="modal-header">
							<h5 class="modal-title">Add New Course  </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
                            <form action="{{ route('projectleader.addquiz') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h4 class="card-title">Resource Details</h4>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Course Name</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="quiz_name" placeholder="Course Name" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            
                                <div class="module-container">
                                    <div id="accordion" class="accordion">
                                        <div class="card cardmodule">
                                            <div class="card-header" id="heading1">
                                                <h5 class="mb-0">
                                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                        Module 1
                                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="module">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <h4 class="card-title">Module 1</h4>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="module_1" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="module_1_completion_percentage" placeholder="Module Percentage" class="form-control" value="">
                                                                    <small>% required to pass</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion1" class="col-xl-12 mcq accordion1 mcq" >
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right" data-modulesid="1">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardmodule">
                                            <div class="card-header" id="heading2">
                                                <h5 class="mb-0">
                                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                                                        Module 2
                                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse2" class="collapse show" aria-labelledby="heading2" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="module">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <h4 class="card-title">Module 2</h4>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="module_2" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="module_2_completion_percentage" placeholder="Module Percentage" class="form-control" value="">
                                                                    <small>% required to pass</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion2" class="col-xl-12 mcq accordion2 mcq">
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right" data-modulesid="2">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardmodule">
                                            <div class="card-header" id="heading3">
                                                <h5 class="mb-0">
                                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                                                        Module 3
                                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="module">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <h4 class="card-title">Module 3</h4>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="module_3" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="module_3_completion_percentage" placeholder="Module Percentage" class="form-control" value="">
                                                                    <small>% required to pass</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion3" class="col-xl-12 mcq accordion3 mcq">
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right" data-modulesid="3">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardmodule">
                                            <div class="card-header" id="heading4">
                                                <h5 class="mb-0">
                                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                                                        Module 4
                                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse4" class="collapse show" aria-labelledby="heading4" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="module">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <h4 class="card-title">Module 4</h4>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="module_4" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="module_4_completion_percentage" placeholder="Module Percentage" class="form-control" value="">
                                                                    <small>% required to pass</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion4" class="col-xl-12 mcq accordion4 mcq">
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right" data-modulesid="4">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardmodule">
                                            <div class="card-header" id="heading5">
                                                <h5 class="mb-0">
                                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
                                                        Module 5
                                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse5" class="collapse show" aria-labelledby="heading5" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="module">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <h4 class="card-title">Module 5</h5>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="module_5" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="module_5_completion_percentage" placeholder="Module Percentage" class="form-control" value="">
                                                                    <small>% required to pass</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion5" class="col-xl-12 mcq accordion5 mcq">
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right" data-modulesid="5">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card cardmodule">
                                            <div class="card-header" id="heading6">
                                                <h5 class="mb-0">
                                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
                                                        Module 6
                                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse6" class="collapse show" aria-labelledby="heading6" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="module">
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <h4 class="card-title">Module 6</h6>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="module_6" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input type="text" name="module_6_completion_percentage" placeholder="Module Percentage" class="form-control" value="">
                                                                    <small>% required to pass</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion6" class="col-xl-12 mcq accordion6 mcq">
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right" data-modulesid="6">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
            <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
            {{-- <script>
                $(document).ready(function() {
                
                let moduleId = 0; // Declaring moduleId outside the click event handler function
               
                $(document).on('click', '.add-mcq', function() {
                    moduleId++; // Increment moduleId using the increment operator
                    let moduleIndex = $(this).closest('.add-mcq').data('modulesid');
                    const mcqHtml = `
                        <div class="card">
                            <div class="card-header" id="heading${moduleIndex}mcq${moduleId}">
                                <h5 class="mb-0">
                                    <a class="btn btn-block btn-warning" data-toggle="collapse" data-target="#collapse${moduleIndex}mcq${moduleId}" aria-expanded="true" aria-controls="collapse${moduleIndex}mcq${moduleId}">
                                        MCQ Section ${moduleId} for module ${moduleIndex}
                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse${moduleIndex}mcq${moduleId}" class="collapse show" aria-labelledby="heading${moduleIndex}mcq${moduleId}" data-parent="#accordion${moduleIndex}">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Question</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][question]" placeholder="Enter Question" value="test question 1" class="form-control" required>
                                            <input type="hidden" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][user_selected_option]"  value="null">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 1</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][options][]" placeholder="Option 1" value="aa" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 2</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][options][]" placeholder="Option 2" value="bb" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 3</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][options][]" placeholder="Option 3" value="cc" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 4</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][options][]" placeholder="Option 4" value="dd" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Correct Answer</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${moduleId}][correct_answer]" placeholder="Correct Answer" value="2" class="form-control" required>
                                        </div>
                                    </div>
                                        <button type="button" class="btn btn-sm mt-2 btn-warning float-right delete-mcq">Delete MCQ</button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $(`#accordion${moduleIndex}`).append(mcqHtml);
                });
            
                    // Delete MCQ Button Click Event
                    $(document).on('click', '.delete-mcq', function() {
                        $(this).closest('.card').remove();
                    });
                });
            </script> --}}
            
            <script>
                $(document).ready(function() {
                    let moduleCounters = {}; // Object to store MCQ counters for each module
            
                    $(document).on('click', '.add-mcq', function() {
                        let moduleIndex = $(this).closest('.add-mcq').data('modulesid');
                        
                        // Initialize the counter if it doesn't exist for the module
                        if (!moduleCounters.hasOwnProperty(moduleIndex)) {
                            moduleCounters[moduleIndex] = 1; // Start with MCQ 1 for this module
                        }
            
                        let mcqNumber = moduleCounters[moduleIndex]; // Get the current MCQ number for this module
                        const mcqHtml = `
                            <div class="card">
                                <div class="card-header" id="heading${moduleIndex}mcq${mcqNumber}">
                                    <h5 class="mb-0">
                                        <a class="btn btn-block btn-warning" data-toggle="collapse" data-target="#collapse${moduleIndex}mcq${mcqNumber}" aria-expanded="true" aria-controls="collapse${moduleIndex}mcq${mcqNumber}">
                                            MCQ Section ${mcqNumber} for module ${moduleIndex}
                                            <i class="fe fe-plus ml-2 float-right"></i> 
                                            <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapse${moduleIndex}mcq${mcqNumber}" class="collapse show" aria-labelledby="heading${moduleIndex}mcq${mcqNumber}" data-parent="#accordion${moduleIndex}">
                                    <div class="card-body">
                                        <!-- MCQ form content -->
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Question</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][question]" placeholder="Enter Question" value="" class="form-control" required>
                                                <input type="hidden" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][user_selected_option]"  value="null">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 1</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][options][]" placeholder="Option 1" value="aa" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 2</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][options][]" placeholder="Option 2" value="bb" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 3</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][options][]" placeholder="Option 3" value="cc" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 4</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][options][]" placeholder="Option 4" value="dd" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Correct Answer</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="module_${moduleIndex}_quiz[mcqs][${mcqNumber}][correct_answer]" placeholder="Correct Answer" value="2" class="form-control" required>
                                        </div>
                                    </div>
                                    <!--
                                        <button type="button" class="btn btn-sm mt-2 btn-warning float-right delete-mcq">Delete MCQ</button>
                                        -->

                                    </div>
                                </div>
                            </div>
                        `;
                        
                        // Append the new MCQ section HTML to the corresponding module accordion
                        $(`#accordion${moduleIndex}`).append(mcqHtml);
            
                        moduleCounters[moduleIndex]++; // Increment the MCQ counter for this module
                    });
            
                    $(document).on('click', '.delete-mcq', function() {
                        let moduleIndex = $(this).closest('.add-mcq').data('modulesid');
                        
                        // Decrement the MCQ counter for the corresponding module
                        if (moduleCounters.hasOwnProperty(moduleIndex)) {
                            moduleCounters[moduleIndex]--;
                        }
            
                        // Remove the MCQ section
                        $(this).closest('.card').remove();
                    });
                });
            </script>


            <script>
                $(document).ready(function() {
                    // Add event listener for accordion show event
                    $('.accordion').on('show.bs.collapse', function (e) {
                    // Find the button that triggered the event
                    var button = $(e.target).prev();
                    // Hide the plus icon and show the minus icon
                    button.find('.fe-plus').addClass('d-none');
                    button.find('.fe-minus').removeClass('d-none');
                    });

                    // Add event listener for accordion hide event
                    $('.accordion').on('hide.bs.collapse', function (e) {
                    // Find the button that triggered the event
                    var button = $(e.target).prev();
                    // Hide the minus icon and show the plus icon
                    button.find('.fe-minus').addClass('d-none');
                    button.find('.fe-plus').removeClass('d-none');
                    });
                });
            </script>

@endsection