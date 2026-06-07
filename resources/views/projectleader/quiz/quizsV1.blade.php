@extends('layouts.projectleader.master')
@section('title','Manage Quiz List')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Manage Quiz List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User List </li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="#Add_ProjectMangrDetails" data-toggle="modal" class="btn btn-primary float-right mt-2">Add New Quiz</a>
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
                                        @foreach ($resourcesdatalist as $item)
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
                                            <div class="modal-dialog modal-dialog-centered" role="document">
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
                                                                @php
                                                                    $quizModules = json_decode($item->quiz_modules, true);
                                                                @endphp
                                                                @foreach($quizModules as $index => $module)
                                                                <div class="module">
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <h4 class="card-title">Module {{ $index + 1 }}</h4>
                                                                            <div class="form-group row">
                                                                                <label class="col-lg-3 col-form-label">Module Name</label>
                                                                                <div class="col-lg-6">
                                                                                    <select class="form-control" name="modules[{{ $index }}][module_name]">
                                                                                        <option>-- Select Resource --</option>
                                                                                        @php
                                                                                            $resourceData = DB::select("SELECT * FROM resources");
                                                                                        @endphp
                                                                                        @foreach ($resourceData as $resourceitem)
                                                                                            <option value="{{ $resourceitem->id }}" {{ $module['module_name'] == $resourceitem->id ? 'selected' : '' }}>{{ $resourceitem->resource_type }} | {{ $resourceitem->resource_name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-lg-3">
                                                                                    <input type="text" name="modules[{{ $index }}][module_order]" placeholder="Module Order" class="form-control" value="{{ $module['module_order'] }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        
                                                            <div class="mcq-container">
                                                                {{-- @dd($resourceitem) --}}
                                                                @php
                                                                    $quizContent = json_decode($item['quiz_content'], true);
                                                                @endphp
                                                                @foreach($quizContent as $mcq)
                                                                    <div class="mcq">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <h4 class="card-title">MCQ Section</h4>
                                                                                <div class="form-group row">
                                                                                    <label class="col-lg-3 col-form-label">Question</label>
                                                                                    <div class="col-lg-9">
                                                                                        <input type="text" name="mcqs[{{$loop->index}}][question]" value="{{ $mcq['question'] }}" placeholder="Enter Question" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                @foreach($mcq['options'] as $optionIndex => $option)
                                                                                    <div class="form-group row">
                                                                                        <label class="col-lg-3 col-form-label">Option {{$optionIndex + 1}}</label>
                                                                                        <div class="col-lg-9">
                                                                                            <input type="text" name="mcqs[{{$loop->parent->index}}][options][]" value="{{ $option }}" placeholder="Option {{$optionIndex + 1}}" class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                                <div class="form-group row">
                                                                                    <label class="col-lg-3 col-form-label">Correct Answer</label>
                                                                                    <div class="col-lg-9">
                                                                                        <input type="text" name="mcqs[{{$loop->index}}][correct_answer]" value="{{ $mcq['correct_answer'] }}" placeholder="Correct Answer" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
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
							<h5 class="modal-title">Add New Quiz  </h5>
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
                                            <label class="col-lg-3 col-form-label">Quiz Name</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="quiz_name" placeholder="Quiz Name" class="form-control">
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            
                                <div class="module-container">
                                    <div class="module">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h4 class="card-title">Module 1</h4>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Module Name</label>
                                                    <div class="col-lg-6">
                                                        <select class="form-control" name="modules[0][module_name]" >
                                                            <option>-- Select Resource --</option>
                                                            @php
                                                                $resourceData = DB::select("SELECT * FROM resources");
                                                            @endphp
                                                            @foreach ($resourceData as $item)
                                                                <option value="{{ $item->id }}">{{ $item->resource_type  }} | {{ $item->resource_name  }} </option>    
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input type="text" name="modules[0][module_order]" placeholder="Module Order" class="form-control">
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-sm btn-success float-right" id="add-module">Add More Module</button>
                                    </div>
                                </div>

                                <div class="mcq-container">
                                    <div class="mcq">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <h4 class="card-title">MCQ Section</h4>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Question</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="mcqs[0][question]" placeholder="Enter Question" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Option 1</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="mcqs[0][options][]" placeholder="Option 1" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Option 2</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="mcqs[0][options][]" placeholder="Option 2" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Option 3</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="mcqs[0][options][]" placeholder="Option 3" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Option 4</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="mcqs[0][options][]" placeholder="Option 4" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label">Correct Answer</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" name="mcqs[0][correct_answer]" placeholder="Correct Answer" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-sm btn-success float-right" id="add-mcq">Add More MCQ</button>
                                    </div>
                                </div>
                            
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const addModuleButton = document.getElementById('add-module');
                                    const addMCQButton = document.getElementById('add-mcq');
                                    const moduleContainer = document.querySelector('.module-container');
                                    const mcqContainer = document.querySelector('.mcq-container');
                            
                                    let moduleIndex = 1; // Start with Module 1
                                    let mcqIndex = 1; // Start with MCQ 1
                            
                                    addModuleButton.addEventListener('click', function() {
                                        const newModule = document.createElement('div');
                                        newModule.classList.add('module');
                            
                                        newModule.innerHTML = `
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <h4 class="card-title">Module ${moduleIndex + 1}</h4>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Module Name</label>
                                                        <div class="col-lg-6">
                                                            <select class="form-control" name="modules[${moduleIndex}][module_name]">
                                                                <option>-- Select Resource --</option>
                                                                @foreach ($resourceData as $item)
                                                                <option value="{{ $item->id }}">{{ $item->resource_type  }} | {{ $item->resource_name  }} </option>    
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <input type="text" name="modules[${moduleIndex}][module_order]" placeholder="Module Order" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        `;
                            
                                        moduleContainer.appendChild(newModule);
                                        moduleIndex++;
                                    });
                            
                                    addMCQButton.addEventListener('click', function() {
                                        const newMCQ = document.createElement('div');
                                        newMCQ.classList.add('mcq');
                            
                                        newMCQ.innerHTML = `
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <h4 class="card-title">MCQ Section</h4>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Question</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="mcqs[${mcqIndex}][question]" placeholder="Enter Question" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Option 1</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="mcqs[${mcqIndex}][options][]" placeholder="Option 1" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Option 2</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="mcqs[${mcqIndex}][options][]" placeholder="Option 2" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Option 3</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="mcqs[${mcqIndex}][options][]" placeholder="Option 3" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Option 4</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="mcqs[${mcqIndex}][options][]" placeholder="Option 4" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Correct Answer</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="mcqs[${mcqIndex}][correct_answer]" placeholder="Correct Answer" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                        `;
                            
                                        mcqContainer.appendChild(newMCQ);
                                        mcqIndex++;
                                    });
                                });
                            </script>
                            
						</div>
					</div>
				</div>
			</div>
			<!-- /ADD Modal -->
@endsection