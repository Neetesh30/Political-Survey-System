<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
            
            @yield('content')
            
        </div>

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
        
    </body>
    </html>
    