@extends('layouts.app')

@section('content')

                    @if (Session::get('danger'))
                    <div class="alert alert-danger">
                        {{ Session::get('danger') }}
                    </div>
                    @endif
                    @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif

                    @foreach ($errors->all() as $message)
                        <div class="alert alert-danger">
                                {{$message}}
                            </div>
                    @endforeach

          
                    <form method="POST" action="{{ route('moblogin') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone Number') }}</label>

                            <div class="col-md-8">
                                <input id="phone" name="phone" type="text" class="form-control mobile @error('phone') is-invalid @enderror"  value="{{ old('phone') }}" required autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <p id="otptimer" class="otptimer"></p> <!-- Display OTP message -->
                                <button type="button" class="btn btn-sm btn-dark sendOTP float-right" id="sendOTP">Send OTP Request</button>
                                <span id="otpMessage" class="otpMessage"></span> <!-- Display OTP message -->
                            <br>
                            <br>
                            
                            <div class="form-group otpField" id="otpField"  style="display: none;">
                                <label for="otp_code">Enter 6 Digit OTP:</label>
                                <input type="text" class="form-control" id="otp_code" name="otp" required>
                            </div>

                            </div>



                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <div class="login-or">
                                    <span class="or-line"></span>
                                    <span class="span-or">or</span>
                                    <a href="{{ route('login') }}" class="btn btn-facebook btn-block mt-3">Login with Email</a>
                                </div>
                            </div>
                        </div>
                       
                    </form>
                    

                    <script>
                        // Set CSRF token for all AJAX requests
                    
                        $(document).ready(function() {
                            $('.sendOTP').click(function() {
                                var _token = $("input[name='_token']").val();
                    
                                var mobile = $('.mobile').val(); // Get mobile number
                                
                                  // Check if name and mobile number are provided
                                  if (!mobile) {
                                    $('.otpMessage').html('<span class="text-danger">Please provide mobile number</span>');
                                    return; // Exit function if fields are empty
                                }
                    
                    
                                // AJAX request to send OTP
                                $.ajax({
                                    url: "{{ route('sendotp') }}",
                                    type: "POST",
                                    data: {
                                        _token:_token, 
                                        mobile: mobile,
                                    },
                                    success: function(response) {
                                        // Display success message
                                        console.log(response);
                                        $('.otpMessage').html('<span class="text-success">OTP sent successfully check your email or phone</span>');
                                         
                                        // Display the "Enter 6 Digit OTP" field
                                        $('.otpField').show();
                    
                                        $('.sendOTP').prop('disabled', true);
                                        startResendTimer();
                    
                                    },
                                    error: function(xhr, status, error) {
                                        // Handle error
                                        console.error("Error sending OTP:", error);
                                        $('.otpMessage').html('<span class="text-danger">Failed to send OTP</span>');
                                    }
                                });
                            });
                             // Function to start timer for resend OTP after 30 seconds
                             function startResendTimer() {
                            var timeLeft = 30;
                            var timer = setInterval(function() {
                                if (timeLeft <= -1) {
                                    clearInterval(timer);
                                    $('.otpMessage').text(''); // Clear message
                                    // Enable the "Send OTP" button after timer ends
                                    $('.sendOTP').prop('disabled', false);
                                    return;
                                }
                                $('.otptimer').text('Resend OTP in ' + timeLeft + ' seconds');
                                timeLeft--;
                            }, 1000);
                        }
                        });
                    </script>
@endsection
