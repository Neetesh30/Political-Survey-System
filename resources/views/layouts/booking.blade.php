<!DOCTYPE html> 
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>@yield('title')</title>
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets\img\">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

		<!-- Daterangepikcer CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

		
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

		<!-- Include SweetAlert script via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- Your HTML content -->

<style>
	.hideform{
		display: none;
	}

	.footer .footer-top {
    padding-bottom: 0;
}
</style>

<!-- Your HTML content -->
<style>
	.content {
	background: #f2f2f2;
}
</style>
    </head>
	<body class="account-page">

		<!-- Main Wrapper -->
		<div class="main-wrapper">
		
			
			<!-- Header -->
			<header class="header">
				<nav class="navbar navbar-expand-lg header-nav">
					<div class="navbar-header">
						<a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</a>
						<a href="#" class="navbar-brand logo">
                            <img src="{{ asset('homepgast/') }}/images/a1-logo.png" class="img-fluid" alt="Logo">
							<img src="{{ asset('homepgast/') }}/images/a1-logo.png" style="width:90px;" class="img-fluid" alt="Logo">
						</a>
					</div>
					<div class="main-menu-wrapper">
						<div class="menu-header">
							<a href="#" class="menu-logo">
								<img src="{{ asset('homepgast/') }}/images/a1-logo.png" class="img-fluid" alt="Logo">
								<img src="{{ asset('homepgast/') }}/images/a1-logo.png" class="img-fluid" alt="Logo">
							</a>
							<a id="menu_close" class="menu-close" href="javascript:void(0);">
								<i class="fas fa-times"></i>
							</a>
						</div>
						<ul class="main-nav">
							<li>
								<a href="/">Home</a>
							</li>
						</ul>
					</div>		 
					<ul class="nav header-navbar-rht">
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<i class="far fa-hospital"></i>							
							</div>
							<div class="header-contact-detail">
								<p class="contact-header">Contact</p>
								<p class="contact-info-header"> 1800 2103 006</p>
							</div>
						</li>
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
					</ul>
				</nav>
			</header>
			<!-- /Header -->
		
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12 ">
						
						@yield('content')
								
						</div>
					</div>

				</div>

			</div>		
			<!-- /Page Content -->
   
			<!-- Footer -->
			<footer class="footer bg-white">
				<!-- Footer Top -->
				<div class="footer-top">
					<div class="container">
						<div class="row">
							<div class="col-lg-3 col-md-6">
							
								<!-- Footer Widget -->
								<div class="footer-widget footer-about">
									<div class="footer-logo">
										<img width="50%" src="{{ asset('homepgast/') }}/images/a1-logo.png" alt="our logo">
									</div>
									<div class="footer-about-content">
									</div>
								</div>
								<!-- /Footer Widget -->
								
							</div>
							
						</div>
					</div>
				</div>
				<!-- /Footer Top -->
				
				<!-- Footer Bottom -->
                <div class="footer-bottom bg-white">
					<div class="container ">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0  text-dark">
											<small>© Saarathi Healthcare Private Ltd is a dynamic Healthcare Company with a vision to democratize healthcare world over, the company has always worked towards filling the gaps in healthcare deliverables</small>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href=""><span class="text-dark">Terms and Conditions </span></a></li>
											<li class="text-dark"><a href=""><span class="text-dark"> Policy </span></a></li>
										</ul>
									</div>
									<!-- /Copyright Menu -->
									
								</div>
							</div>

						</div>
						<!-- /Copyright -->
						
					</div>
				</div>
				<!-- /Footer Bottom -->
				
			</footer>
			<!-- /Footer -->
		   
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>

		<!-- Daterangepikcer JS -->
		<script src="{{ asset('assets/js/moment.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	
		
		<!-- Custom JS -->
		<script src="{{ asset('assets/js/script.js') }}"></script>
	</body>

	{{-- <script>
		$(document).ready(function() {
			// Show the pincode selection modal on page load
			$('#pincodeSelectionModal').modal('show');
			$('#pincodeSelectionModal').modal({ backdrop: true, keyboard: false });
		});
	</script> --}}

	<!-- Conditionally show or hide the modal based on the pincode session -->
	@if(session('pincode'))
	<script>
		// If pincode session is set, hide the modal
		$(document).ready(function () {
			$('#pincodeSelectionModal').modal('hide');
		});
	</script>
	@else
	<script>
		// If pincode session is not set, show the modal
		$(document).ready(function () {
			$('#pincodeSelectionModal').modal('show');
		});
	</script>
	@endif

	<!-- Add this script at the end of your HTML body or in a separate script file -->
	<script>
		  $(document).ready(function () {
            $('#search-job-drop-icon').show();
            $('#search-job-clear-icon').hide();
            $(".dropdown-item").click(function () {
                var selectedValue = $(this).attr('data-value');
                var selectedValueid = $(this).attr('data-valueid');
                $("#dropdown-search").val(selectedValue);
                $("#dropdown-searchid").val(selectedValueid);
                updateskillcontainer(selectedValue);
                $('.dropdown-menu').hide();
                $('#search-job-drop-icon').hide();
                $('#search-job-clear-icon').show();
                
            });
    
            
    
            $("#dropdown-search").on("input", function() {
				var searchValue = $(this).val();
				filterDropdown(searchValue);
				if (searchValue.length > 0) {
					$('#search-job-drop-icon').hide();
					$('#search-job-clear-icon').show();
				} else {
					$('#search-job-clear-icon').hide();
					$('#search-job-drop-icon').show();
				}
			});

            $('#search-job-clear-icon').click(function() {
                $('#dropdown-search').val('');
                $('#dropdown-searchid').val('');
                $(this).hide();
                $('.dropdown-menu').show();
                $('.dropdown-item').show();
            });
    
			function filterDropdown(value) {
					var found = false;
					$(".dropdown-item").each(function() {
						var optionValue = $(this).attr('data-value').toString(); // Convert to string
						if (optionValue.includes(value)) {
							$(this).show();
							found = true;
						} else {
							$(this).hide();
						}
					});

					if (!found) {
						$('.pincoderror').text('Sorry, this pincode is not in service');
					} else {
						$('.pincoderror').text('');
					}
				}
				
				$('.time_select input[type="radio"]').on('change', function() {
					
					var $chkform = $(this).closest('.aptForm'); // Find the parent form

					var chkhide = $chkform.find('.chkhide'); 

					chkhide.removeClass('hideform').fadeIn();
					
				});

		});

	</script>


<script>
	// Set CSRF token for all AJAX requests

	$(document).ready(function() {
		$('.sendOTP').click(function() {
			var _token = $("input[name='_token']").val();

			var $form = $(this).closest('.aptForm'); // Find the parent form

			@if(session('booked_id'))
				mobile = '{{ session('booked_phone') }}';
				name = '{{ session('booked_name') }}';
			@else
				var $form = $(this).closest('.aptForm'); // Find the parent form
				mobile = $form.find('.mobile').val(); // Get mobile number
				name = $form.find('.name').val(); // Get name
			@endif


			  // Check if name and mobile number are provided
			  if (!name || !mobile) {
				$form.find('.otpMessage').text('<span class="text-danger">Please provide name and mobile number</span>>');
				return; // Exit function if fields are empty
			}


			// AJAX request to send OTP
			$.ajax({
				url: "{{ route('sendotp') }}",
				type: "POST",
				data: {
					_token:_token, 
					name: name,
					mobile: mobile,
				},
				success: function(response) {
					// Display success message
					$form.find('.otpMessage').html('<span class="text-success">OTP sent successfully</span>');
					 
					// Display the "Enter 6 Digit OTP" field
					$form.find('.otpField').show();

					$form.find('.sendOTP').prop('disabled', true);
					startResendTimer($form);

				},
				error: function(xhr, status, error) {
					// Handle error
					console.error("Error sending OTP:", error);
					$form.find('.otpMessage').html('<span class="text-danger">Failed to send OTP</span>');
				}
			});
		});
		 // Function to start timer for resend OTP after 30 seconds
		 function startResendTimer($form) {
        var timeLeft = 30;
        var timer = setInterval(function() {
            if (timeLeft <= -1) {
                clearInterval(timer);
                $form.find('.otpMessage').text(''); // Clear message
                // Enable the "Send OTP" button after timer ends
                $form.find('.sendOTP').prop('disabled', false);
                return;
            }
            $form.find('.otptimer').text('Resend OTP in ' + timeLeft + ' seconds');
            timeLeft--;
        }, 1000);
    }
});
</script>

<script>
$(document).ready(function() {
    $('form').submit(function(event) {
        // Prevent the default form submission
        event.preventDefault();

        // Check if all required fields are filled
        var allFieldsFilled = true;
        $(this).find('input[required], select[required], textarea[required]').each(function() {
            if (!$(this).val()) {
                allFieldsFilled = false;
                return false; // Exit the loop early if a required field is empty
            }
        });

        // If all required fields are filled
        if (allFieldsFilled) {
            // Disable the submit button and change its text
            var $submitButton = $(this).find('button[type="submit"]');
            $submitButton.prop('disabled', true).text('Processing...');
            
            // Proceed with form submission
            this.submit();
        } else {
            // If any required field is empty, display an alert or perform any other action as needed
            alert('Please fill in all required fields.');
        }
    });
});

</script>
	

@if (Session::get('success'))
	<script>
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: 'Appointment booked successfully!',
			showConfirmButton: false,
		});
	</script>
@endif

	
	

	<!-- Pincode Selection Modal -->
	<div class="modal" id="pincodeSelectionModal" tabindex="-1" role="dialog" aria-labelledby="pincodeSelectionModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="pincodeSelectionModalLabel">Select Pincode</h5>
					<!-- Remove the close button from the header -->
				</div>
				<div class="modal-body">
					<!-- Add a form to select the pincode -->
					<form id="pincodeSelectionFormf" action="{{ route('booking') }}" method="post" class="form">
						@csrf
						<div class="form-group">
							<label for="dropdown">Select Your Pincode:</label>
							<div class="dropdown">
								<input type="text" id="dropdown-search" autocorrect="off" spellcheck="false" autocomplete="off" name="pincode" class="form-control dropdown-search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-field-id="resumeTitle" placeholder="Search pincode ..." />
								<input type="hidden" id="dropdown-searchid" autocorrect="off" spellcheck="false" autocomplete="off" name="pincodeid" class="form-control dropdown-search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-field-id="resumeTitle" placeholder="pincode id ..." />
								<div class="dropdown-menu" aria-labelledby="dropdown">
									@foreach ($pincodelist as $item)
									<div class="dropdown-item" href="{{ $item['id'] }}" data-valueid="{{ (string)$item['id'] }}" data-value="{{ (string)$item['pincode'] }}">{{ $item['pincode'] }}</div>
									@endforeach
								</div>
							</div>
						</div>
						<div class="pincoderror"></div>
						<button type="submit" class="btn btn-warning btn-right">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</html>


