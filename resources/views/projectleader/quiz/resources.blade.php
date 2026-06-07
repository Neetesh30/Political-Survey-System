@extends('layouts.projectleader.master')
@section('title','Manage Quiz Resources')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Manage Resources List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User List </li>
                        </ul>
                    </div>
                    <div class="col-sm-5 col">
                        <a href="#Add_ProjectMangrDetails" data-toggle="modal" class="btn btn-primary float-right mt-2">Add Resources</a>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header" id="ajaxalertcontainer">
                            <h4 class="card-title">Resource List</h4>
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
                                            <th>Resource Name</th>
                                            <th>Type</th>
                                            {{-- <th>Cover image</th> --}}
                                            <th>From Name</th>
                                            <th>From Email</th>
                                            <th>From Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($resourcesdatalist as $item)
                                        <tr>
                                            <td class="text-danger">#RR00{{$item['id']}}</td>
                                            <td class="text-danger">{{$item['resource_name']}}</td>
                                            <td class="">{{$item['resource_type']}}</td>
                                            {{-- <td class="sorting_1">
                                                <h2 class="table-avatar">
                                                    <a href="#" class="avatar avatar-sm mr-2">
                                                        <img src="{{ asset('storage/quiz/' . ($item['resource_cover_img'] ?? 'dummy-profile.png')) }}" alt="Cover Image" class="avatar-img rounded-circle">
                                                    </a>
                                                </h2>
                                            </td> --}}
                                            <td>{{$item['from_name']}}</td>
                                            <td>{{$item['from_email']}}</td>
                                            <td>{{$item['from_phone']}}</td>
                                            <td>
                                                <form id="statusForm_{{$item['id']}}" action="{{route('projectleader.manageresourcestatus')}}" method="POST">
                                                    @csrf
                                                <div class="status-toggle">
                                                    <input type="checkbox" id="status_{{$item['id']}}"  class="check" {{ $item['resource_status'] == 'active' ? 'checked' : '' }} >
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
                                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Resource ID : #RR00{{$item['id']}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('projectleader.editresources')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <h4 class="card-title">User : {{$item['name']}}</h4>
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Name</label>
                                                                        <div class="col-lg-9">
                                                                            <input type="text" name="resource_name" value="{{$item['resource_name']}}" class="form-control">
                                                                            <input type="hidden" class="form-control" name="id" value="{{$item['id']}}">
                                                                        </div>
                                                                    </div>
                                                                    {{-- @if ($item['resource_cover_img'] != null)
                                                                    <div class="form-group row">
                                                                            <label class="col-lg-3 col-form-label">Image</label>
                                                                            <div class="col-lg-9">
                                                                                <img src="{{ asset('storage/quiz/' . ($item['resource_cover_img'] ?? 'dummy-profile.png')) }}" alt="Cover Image" class="img-fluid">
                                                                            </div>
                                                                        </div>
                                                                    @endif --}}
                                                                
                                                                    
                                                                    @if ($item['resource_type'] == 'image')
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Image</label>
                                                                        <div class="col-lg-9">
                                                                            <img src="{{ asset('storage/quiz/'.$item['resource_path']) }}" alt="image" class="img-fluid">
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if ($item['resource_type'] == 'video')
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Video</label>
                                                                        <div class="col-lg-9">
                                                                            <div style='position:relative;height:0;padding-bottom:56.25%'>
                                                                                {!! $item['resource_path']  !!}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if ($item['resource_type'] == 'pdf')
                                                                    <div class="form-group row">
                                                                        <label class="col-lg-3 col-form-label">Pdf</label>
                                                                        <div class="col-lg-9">
                                                                            <embed src="{{ asset('storage/quiz/'.$item['resource_path']) }}" type="application/pdf" width="100%" height="600px">
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                    
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
                                                                <h4 class="modal-title">Delete Id : #RR00{{$item['id']}}</h4>
                                                                <p class="mb-4">Are you sure want to delete 
                                                                    <br>
                                                                    Resource name: {{$item['resource_name']}}
                                                                    <br>
                                                                    Resource type : {{$item['resource_type']}}
                                                                    <br>
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <form action="{{route('projectleader.deleteresources')}}" method="post">
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
							<h5 class="modal-title">Add Resource </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form id="resourceForm" action="{{ route('projectleader.addresources') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h4 class="card-title">Resource Details</h4>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Resource Video Name</label>
                                            <div class="col-lg-9">
                                                <input type="text" name="resource_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Select Resource Type</label>
                                            <div class="col-lg-9">
                                                <select class="form-control" name="resource_type" id="resourceType" required>
                                                    <option value="video">Video</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="fileUploadField" >
                                            <label class="col-lg-3 col-form-label" id="fileLabel">Upload File</label>
                                            <div class="col-lg-9">
                                                <input type="file" name="resource_file" class="form-control-file" id="resourceFile">
                                                <small id="fileHelp" class="form-text text-muted"></small>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="text-right">
                                    <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            <div id="progressBarContainer" class="mt-2 d-none">
                                <div class="progress">
                                    <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div id="progressText" class="text-center"></div>
                            </div>
						</div>
					</div>
				</div>
			</div>
			<!-- /ADD Modal -->
            <!-- jQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	
            <script>
                $(document).ready(function() {
                    $('#resourceForm').submit(function(event) {
                        event.preventDefault();
            
                        // Prepare form data
                        var formData = new FormData($(this)[0]);
            
                        // Disable submit button and show progress bar
                        $('#submitButton').prop('disabled', true).text('Uploading...');
                        $('#progressBarContainer').removeClass('d-none');
            
                        // AJAX request to submit form data
                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener('progress', function(event) {
                                    if (event.lengthComputable) {
                                        var percentComplete = Math.round((event.loaded / event.total) * 100);
                                        $('#progressBar').css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
                                        $('#progressText').text(percentComplete + '% Complete');

                                         // Check if upload is complete
                                        if (percentComplete === 100) {
                                            $('#progressText').text('Upload Complete, waiting for response...'); // Change text when upload is complete
                                        }
                                    }
                                }, false);
                                return xhr;
                            },
                            success: function(response) {
                                // Handle success response
                                console.log('File uploaded successfully:', response);
                                $('#submitButton').text('Video Uploaded successfully');
                                $('#ajaxalertcontainer').append(`
                                <div class="alert alert-success">Video Uploaded successfully. Page will refresh in 3 seconds...  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button></div>`);
                                $('#Add_ProjectMangrDetails').modal('hide');
                                // Wait for 3 seconds before reloading the page
                                setTimeout(function() {
                                    location.reload();
                                }, 3000);
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                console.error('Error occurred while uploading file:', error);
                                // Optionally, display an error message or perform any other actions
                                $('#submitButton').text('Submit');

                                $('#ajaxalertcontainer').append(`<div class="alert alert-danger">Video Uploaded successfully error: ${error}
                                    , Page will refresh in 5 seconds... <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button></div>
                                    </div>`);
                                $('#Add_ProjectMangrDetails').modal('hide');
                                // Wait for 3 seconds before reloading the page
                                setTimeout(function() {
                                    location.reload();
                                }, 5000);
                            },
                            complete: function() {
                                // Enable submit button and hide progress bar
                                $('#submitButton').prop('disabled', false);
                                $('#progressBarContainer').addClass('d-none');
                            }
                        });
                    });
                });
            </script>            
@endsection