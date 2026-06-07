@extends('layouts.campexe.master-upload')

@section('content')
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10">
                @if(session('success'))
                <div>{{ session('success') }}</div>
            @endif
    
            @if(session('error'))
                <div>{{ session('error') }}</div>
            @endif
    
            @if(session('response'))
                <pre>{{ print_r(session('response'), true) }}</pre>
            @endif
            <form id="uploadForm" action="{{ route('user.upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="custom-filew mb-3">
                        <input type="file" class="custom-file-inputww" id="customFile" name="video">
                        <label class="custom-file-labelww" for="customFile">Choose file</label>
                    </div>
                    <button type="submit" id="uploadButton" class="btn btn-primary">Upload</button>
                    <br>
                    <br>
                    <a href="{{ route('user.home') }}" class="btn btn-danger text-white">Go Back </a>
            </form>
            <small class="text-danger">Only Videos can be uploaded, maximum upload size is <strong>500MB</strong>.</small>
            
            <div id="progressBars" class="mt-4"></div>
            <div id="uploadStatus" class="mt-3"></div> <!-- Placeholder for upload status -->

            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const progressBars = document.getElementById('progressBars');

        function getConnectionStrength() {
            const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            if (!connection) return 'Unknown';
            const speed = connection.downlink;
            if (speed > 10) return 'Fast'; // Adjust the threshold as needed
            if (speed > 2) return 'Moderate'; // Adjust the threshold as needed
            return 'Slow';
        }

        form.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const fileInput = document.querySelector('input[type="file"]');
            const file = fileInput.files[0];

            // Check if a file is selected
            if (!file) {
                alert('Please select a file.');
                return;
            }

            // Check if the selected file is a video
            if (!file.type.startsWith('video/')) {
                alert('Please select a video file.');
                return;
            }

            // Check if the file size is not more than 512MB
            const maxFileSize = 512 * 1024 * 1024; // 512MB in bytes
            if (file.size > maxFileSize) {
                alert('File size exceeds the maximum limit of 512MB.');
                return;
            }

            const formData = new FormData(form);
            const fileName = file.name;
            
            // Disable the form button and change its text to "Processing..."
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';


            const progressBar = document.createElement('section');
            progressBar.classList.add('div', 'mb-3');
            progressBar.innerHTML = `
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">${fileName} - 0%</div>
                </div>
                <div><small class="upload-speed">Upload speed: Calculating...</small></div>
                <div><small class="connection-strength">Network connection: Calculating...</small></div>
                <div><pre class="response-data text-danger">Response data: Video Processing... please do not refresh or go back</pre></div>
                <div><small id="uploadStatus">Processing... Time Remaining: Calculating... seconds</small></div>
            `;
            progressBars.appendChild(progressBar);

            const progressBarInner = progressBar.querySelector('.progress-bar');
            const uploadSpeedText = progressBar.querySelector('.upload-speed');
            const connectionStrengthText = progressBar.querySelector('.connection-strength');
            const responseDataText = progressBar.querySelector('.response-data');

            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function (event) {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    progressBarInner.style.width = percentComplete + '%';
                    progressBarInner.innerHTML = `${fileName} - ${Math.round(percentComplete)}%`;

                    const currentTime = Date.now();
                    const elapsedTime = (currentTime - startTime) / 1000;
                    const uploadSpeed = event.loaded / elapsedTime;
                    uploadSpeedText.textContent = `Upload speed: ${formatBytes(uploadSpeed)}/s`;
                }
            });

            xhr.addEventListener('load', function (event) {
                progressBarInner.innerHTML = `${fileName} - Upload Complete`;
                responseDataText.textContent = 'Response data:\n' + xhr.responseText;

                if (xhr.status === 200) {
                    window.location.href = '{{ route('user.home') }}';
                }
            });

            xhr.addEventListener('error', function (event) {
                progressBarInner.innerHTML = `${fileName} - Upload Failed`;
            });

            xhr.open('POST', form.getAttribute('action'));
            xhr.send(formData);

            const startTime = Date.now();
            setInterval(() => {
                const elapsedTime = Math.round((Date.now() - startTime) / 1000);
                document.getElementById('uploadStatus').textContent = `Processing... Time Remaining: ${Math.max(0, 600 - elapsedTime)} seconds`;
            }, 1000);

            // Determine and display network connection strength
            const connectionStrength = getConnectionStrength();
            connectionStrengthText.textContent = `Network connection: ${connectionStrength}`;
            if (connectionStrength === 'Fast') {
                connectionStrengthText.style.color = 'green';
            } else if (connectionStrength === 'Moderate') {
                connectionStrengthText.style.color = 'orange';
            } else {
                connectionStrengthText.style.color = 'red';
            }
        });

        form.addEventListener('progress', function (event) {
            if (event.lengthComputable) {
                const progress = event.loaded / event.total;
                document.getElementById('uploadStatus').textContent = `Processing... Time Remaining: Calculating... seconds`;
            }
        });
    });

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = 2 < 0 ? 0 : 2;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
</script>

    
</body>
    
@endsection

@section('content-old')
<!-- Page Wrapper -->
<div class="page-wrapper">
			
    <div class="content container-fluid">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Upload Doctors Video</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Upload Video</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {!! Session::get('fail')  !!}
                </div>
            @endif
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {!! Session::get('success')  !!}
                </div>
            @endif

            @if(session('response'))
            <pre>{{ print_r(session('response'), true) }}</pre>
        @endif
            </div>
            
        </div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Upload Video Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.upload') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-md-2">Video Input</label>
                                <div class="col-md-10">
                                    <input type="file" class="form-control" id="customFile" name="videos[]" >
                                </div>
                            </div>
                           
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div id="progressBars" class="mt-4"></div>

                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const form = document.querySelector('form');
                                    const progressBars = document.getElementById('progressBars');
                            
                                    // Function to determine network connection strength
                                    function getConnectionStrength() {
                                        const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
                                        if (!connection) return 'Unknown';
                                        const speed = connection.downlink;
                                        if (speed > 10) return 'Fast'; // Adjust the threshold as needed
                                        if (speed > 2) return 'Moderate'; // Adjust the threshold as needed
                                        return 'Slow';
                                    }
                            
                                    form.addEventListener('submit', function (event) {
                                        event.preventDefault();
                                        const formData = new FormData(form);
                            
                                        // Iterate through each selected file
                                        formData.getAll('videos[]').forEach(function (file) {
                                            const fileName = file.name; // Get the file name
                            
                                            const progressBar = document.createElement('section');
                                            progressBar.classList.add('div', 'mb-3');
                                            progressBar.innerHTML = `
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">${fileName} - 0%</div>
                                                </div>
                                                <div><small class="upload-speed">Upload speed: Calculating...</small></div>
                                                <div><small class="connection-strength">Network connection: Calculating...</small></div>
                                            `;
                                            progressBars.appendChild(progressBar);
                            
                                            const progressBarInner = progressBar.querySelector('.progress-bar');
                                            const uploadSpeedText = progressBar.querySelector('.upload-speed');
                                            const connectionStrengthText = progressBar.querySelector('.connection-strength');
                            
                                            let startTime;
                                            let lastLoaded = 0;
                            
                                            const xhr = new XMLHttpRequest();
                            
                                            // Track progress
                                            xhr.upload.addEventListener('progress', function (event) {
                                                if (event.lengthComputable) {
                                                    const percentComplete = (event.loaded / event.total) * 100;
                                                    progressBarInner.style.width = percentComplete + '%';
                                                    progressBarInner.innerHTML = `${fileName} - ${Math.round(percentComplete)}%`;
                            
                                                    const currentTime = new Date().getTime();
                                                    const elapsedTime = (currentTime - startTime) / 1000; // in seconds
                                                    const uploadedBytes = event.loaded - lastLoaded;
                                                    const uploadSpeed = uploadedBytes / elapsedTime; // in bytes per second
                            
                                                    // Update upload speed text
                                                    uploadSpeedText.textContent = `Upload speed: ${formatBytes(uploadSpeed)}/s`;
                                                    
                                                    lastLoaded = event.loaded;
                                                    startTime = currentTime;
                                                }
                                            });
                            
                                            // Handle upload start
                                            xhr.upload.addEventListener('loadstart', function () {
                                                startTime = new Date().getTime();
                                            });
                            
                                            // Handle upload completion
                                            xhr.addEventListener('load', function (event) {
                                                progressBarInner.innerHTML = `${fileName} - Upload Complete`;
                                            });
                            
                                            // Handle errors
                                            xhr.addEventListener('error', function (event) {
                                                progressBarInner.innerHTML = `${fileName} - Upload Failed`;
                                            });
                            
                                            // Send AJAX request to upload file
                                            xhr.open('POST', form.getAttribute('action'));
                                            xhr.send(formData);
                            
                                            // Update network connection strength text and color
                                            const connectionStrength = getConnectionStrength();
                                            connectionStrengthText.textContent = `Network connection: ${connectionStrength}`;
                                            if (connectionStrength === 'Fast') {
                                                connectionStrengthText.style.color = 'green';
                                            } else if (connectionStrength === 'Moderate') {
                                                connectionStrengthText.style.color = 'orange';
                                            } else {
                                                connectionStrengthText.style.color = 'red';
                                            }
                                            
                                        });
                                    });
                            
                                    // Function to format bytes to human-readable format
                                    function formatBytes(bytes) {
                                        if (bytes === 0) return '0 Bytes';
                                        const k = 1024;
                                        const dm = 2 < 0 ? 0 : 2;
                                        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                                        const i = Math.floor(Math.log(bytes) / Math.log(k));
                                        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                                    }
                                });
                            </script>
                    </div>
                </div>
            </div>
        </div>
        
    </div>			
</div>
<!-- /Page Wrapper -->
@endsection
