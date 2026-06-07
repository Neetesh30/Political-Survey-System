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
                            <h4 class="card-title">Quiz List</h4>
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
                                            <th>Quiz Name</th>
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
                                            <td class="text-danger">{{$item['quiz_name']}}</td>
                                            <td>{{$item['updatedby_user_name']}}</td>
                                            <td>{{$item['updatedby_user_email']}}</td>
                                            <td>{{$item['updatedby_user_phone']}}</td>
                                            <td>{{$item['quiz_status']}}</td>
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
                                                        <form action="{{route('projectleader.editquiz')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <h4 class="card-title">Resource Details</h4>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Quiz Name</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                                                            <input type="text" name="quiz_name" placeholder="Quiz Name" class="form-control" value="{{ $item->quiz_name }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Quiz Status</label>
                                                                        <div class="col-lg-9">
                                                                            <select class="form-control" name="quiz_status" >
                                                                                <option value="{{ $item->quiz_status }}">-- Current :  {{ $item->quiz_status }} --</option>
                                                                                <option value="new">New</option>
                                                                                <option value="active">Active</option>
                                                                                <option value="inactive">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                        </div>
                                                        
                                                        <div class="edit-module-container">
                                                            <div id="accordion-edit">
                                                                @php
                                                                    $quizModules = json_decode($item->quiz_modules, true);
                                                                    // dd($quizModules);
                                                                @endphp
                                                                @foreach($quizModules as $index => $module)
                                                                <div class="card">
                                                                    <div class="card-header" id="heading{{ $index + 1 }}">
                                                                        <h5 class="mb-0">
                                                                            <a class="btn btn-link btn-block btn-success" data-toggle="collapse" data-target="#collapse{{ $index + 1 }}" aria-expanded="true" aria-controls="collapse{{ $index + 1 }}">
                                                                                Module {{ $index + 1 }}
                                                                            </a>
                                                                        </h5>
                                                                    </div>
                                                                    <div id="collapse{{ $index + 1 }}" class="collapse show" aria-labelledby="heading{{ $index + 1 }}" data-parent="#accordion">
                                                                        <div class="card-body">
                                                                            <div class="module">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <h4 class="card-title">Module {{ $index + 1 }}</h4>
                                                                                        {{-- <button type="button" class="btn btn-danger mt-2 float-right delete-module">Delete Module</button> --}}
                                                                                        <div class="form-group row">
                                                                                            <label class="col-lg-3 col-form-label">Module Name</label>
                                                                                            <div class="col-lg-6">
                                                                                                <select class="form-control" name="modules[{{ $index }}][module_name]" required>
                                                                                                    <option>-- Select Resource --</option>
                                                                                                    @php
                                                                                                        $resourceData = DB::select("SELECT * FROM resources");
                                                                                                    @endphp
                                                                                                    @foreach ($resourceData as $resourceitem)
                                                                                                    <option value="{{ $resourceitem->id }}" {{ $module['module_name'] == $resourceitem->id ? 'selected' : '' }}>{{ $resourceitem->resource_type }} | {{ $resourceitem->resource_name }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-9 offset-md-3">
                                                                                        <div class="mcq-container">
                                                                                            @foreach($module['mcqs'] as $mcqIndex => $mcq)
                                                                                            <div class="card">
                                                                                                <div class="card-header" id="heading{{ $index + 1 }}mcq{{ $mcqIndex }}">
                                                                                                    <h5 class="mb-0">
                                                                                                        <a class="btn btn-link btn-block btn-success" data-toggle="collapse" data-target="#collapse{{ $index + 1 }}mcq{{ $mcqIndex }}" aria-expanded="true" aria-controls="collapse{{ $index + 1 }}mcq{{ $mcqIndex }}">
                                                                                                            MCQ {{ $mcqIndex + 1 }} for Module {{ $index + 1 }}
                                                                                                        </a>
                                                                                                    </h5>
                                                                                                </div>
                                                                                                <div id="collapse{{ $index + 1 }}mcq{{ $mcqIndex }}" class="collapse show" aria-labelledby="heading{{ $index + 1 }}mcq{{ $mcqIndex }}" data-parent="#accordion{{ $index + 1 }}">
                                                                                                    <div class="card-body">
                                                                                                        <div class="form-group">
                                                                                                            <label>Question</label>
                                                                                                            <input type="text" class="form-control" name="modules[{{ $index }}][mcqs][{{ $mcqIndex }}][question]" value="{{ $mcq['question'] }}">
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label>Options</label>
                                                                                                            <!-- Assuming there are four options -->
                                                                                                            @for ($i = 0; $i < 4; $i++)
                                                                                                            <input type="text" class="form-control" name="modules[{{ $index }}][mcqs][{{ $mcqIndex }}][options][]" value="{{ $mcq['options'][$i] }}">
                                                                                                            @endfor
                                                                                                        </div>
                                                                                                        <div class="form-group">
                                                                                                            <label>Correct Answer</label>
                                                                                                            <input type="text" class="form-control" name="modules[{{ $index }}][mcqs][{{ $mcqIndex }}][correct_answer]" value="{{ $mcq['correct_answer'] }}">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            @endforeach
                                                                                        </div>
                                                                                        {{-- <button type="button" class="btn btn-success add-mcq float-right">Add MCQ</button> --}}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
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
                                        <div class="card newmodule">
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
                                                                <button type="button" class="btn btn-danger mt-2 float-right delete-module">Delete Module</button>
                                                                <div class="form-group row">
                                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                                    <div class="col-lg-6">
                                                                        <select class="form-control" name="modules[1][module_name]" required>
                                                                            <option>-- Select Resource --</option>
                                                                            @php
                                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                                            @endphp
                                                                            @foreach ($resourceData as $item)
                                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <input type="hidden" name="modules[1][module_completed]" value="no">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9 offset-md-3">
                                                                <div class="mcq-container">
                                                                    <div id="accordion1" class="col-xl-12 mcq">
                                                                        <!-- MCQ sections will be dynamically added here -->
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-success add-mcq float-right">Add MCQ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <button id="add-module-btn" type="button" class="btn btn-success">Add Module</button>
                        
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
            <script>
                $(document).ready(function() {
                let moduleIndex = 1; // Start module indexing from 1
                
                $('#add-module-btn').click(function() {
                    moduleIndex++;
                    const moduleHtml = `
                        <div class="card">
                            <div class="card-header" id="heading${moduleIndex}">
                                <h5 class="mb-0">
                                    <a class="btn btn-link btn-block btn-success text-white" data-toggle="collapse" data-target="#collapse${moduleIndex}" aria-expanded="true" aria-controls="collapse${moduleIndex}">
                                        Module ${moduleIndex}
                                        <i class="fe fe-plus ml-2 float-right"></i> 
                                        <i class="fe fe-minus ml-2 float-right d-none"></i> 
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse${moduleIndex}" class="collapse show" aria-labelledby="heading${moduleIndex}" data-parent="#accordion">
                                <div class="card-body">
                                    <div class="module">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h4 class="card-title">Module ${moduleIndex}</h4>
                                                <button type="button" class="btn btn-danger mt-2 float-right delete-module">Delete Module</button>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="modules[${moduleIndex}][module_name]" required>
                                                            <option>-- Select Resource --</option>
                                                            @foreach ($resourceData as $item)
                                                                <option value="{{ $item->id }}">{{ $item->resource_type }} | {{ $item->resource_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="modules[${moduleIndex}][module_completed]" value="no">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-9 offset-md-3">
                                                <div class="mcq-container">
                                                    <input type="hidden" name="modules[${moduleIndex}][mcq_completed]" value="no">
                                                    <div id="accordion${moduleIndex}" class="col-xl-12 mcq">
                                                        <!-- MCQ sections will be dynamically added here -->
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-success add-mcq float-right">Add MCQ</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    $('#accordion').append(moduleHtml);
                    
                });

                 // Delete Module Button Click Event
                $(document).on('click', '.delete-module', function() {
                    $(this).closest('.card.newmodule').remove();
                    moduleIndex--; // Decrement moduleIndex when a module is deleted
                });

                let moduleId = 0; // Declaring moduleId outside the click event handler function
                $(document).on('click', '.add-mcq', function() {
                    moduleId++; // Increment moduleId using the increment operator
                    const mcqHtml = `
                        <div class="card">
                            <div class="card-header" id="heading${moduleIndex}mcq${moduleId}">
                                <h5 class="mb-0">
                                    <a class="btn btn-block btn-warning" data-toggle="collapse" data-target="#collapse${moduleIndex}mcq${moduleId}" aria-expanded="true" aria-controls="collapse${moduleIndex}mcq${moduleId}">
                                        MCQ Section ${moduleId} for module ${moduleIndex}
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse${moduleIndex}mcq${moduleId}" class="collapse show" aria-labelledby="heading${moduleIndex}mcq${moduleId}" data-parent="#accordion${moduleIndex}">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Question</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="modules[${moduleIndex}][mcqs][${moduleId}][question]" placeholder="Enter Question" value="test question 1" class="form-control" required>
                                            <input type="hidden" name="modules[${moduleIndex}][mcqs][${moduleId}][user_selected_option]"  value="null">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 1</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="modules[${moduleIndex}][mcqs][${moduleId}][options][]" placeholder="Option 1" value="aa" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 2</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="modules[${moduleIndex}][mcqs][${moduleId}][options][]" placeholder="Option 2" value="bb" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 3</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="modules[${moduleIndex}][mcqs][${moduleId}][options][]" placeholder="Option 3" value="cc" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Option 4</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="modules[${moduleIndex}][mcqs][${moduleId}][options][]" placeholder="Option 4" value="dd" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Correct Answer</label>
                                        <div class="col-lg-9">
                                            <input type="text" name="modules[${moduleIndex}][mcqs][${moduleId}][correct_answer]" placeholder="Correct Answer" value="2" class="form-control" required>
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
                    $(this).closest('.card.newmodule').remove();
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