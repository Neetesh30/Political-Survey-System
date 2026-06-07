
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
            <form id="uploadForm" action="{{ route('user.testUpload') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="custom-filew mb-3">
                        <input type="file" class="custom-file-inputww" id="customFile" name="video">
                        <label class="custom-file-labelww" for="customFile">Choose file</label>
                    </div>
                    <button type="submit" id="uploadButton" class="btn btn-primary">Upload</button>
                    <br>
                    <a href="{{ route('user.home') }}" class="btn btn-danger text-white">Go Back </a>
            </form>
            <small class="text-danger">Only Videos can be uploaded, maximum upload size is <strong>500MB</strong></small>
            </div>
        </div>
    </div>
    
</body>
    
