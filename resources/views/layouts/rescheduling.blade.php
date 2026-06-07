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

		<!-- Include Lottie Library -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.10/lottie.min.js"></script>

        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>


		<!-- Your HTML content -->
		<style>
			.content {
			background: #f2f2f2;
		}

		.footer .footer-top {
    padding-bottom: 0;
}

@media only screen and (max-width: 991px){
	.mobview {
		display: inline-block;
	}
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
    							<img src="{{ asset('homepgast/') }}/images/a1-logo.png" style="width:90px;" class="img-fluid" alt="Logo">
    							<img class="d-none mobview" src="{{ asset('homepgast/') }}/images/a1-logo.png" style="width:90px;" class="img-fluid" alt="Logo">
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
					
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                               <a id="navbarDropdown" class="nav-link dropdown-toggle" href="{{ Auth::user()->role == 5 ? '/campexe/' : (Auth::user()->role == 2 ? '/projectleader/' : '') }}" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
									{{ Auth::user()->name }} | Dashboard
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
						<li class="nav-item contact-item">
							<div class="header-contact-img">
								<img src="{{ asset('homepgast/') }}/images/care-logo.jpg" style="width:110px;" class="img-fluid" alt="Logo">
							</div>
						</li>
					</ul>
				</nav>
			</header>
			<!-- /Header -->

			<!-- Home Banner -->
			{{-- <section class="section section-banner">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-6">
						</div>
						<div class="col-12 col-md-6">
							<div class="banner-wrapper">
								<div class="banner-header">
									<h5>Be Hear Healthy</h5>
									<h1>E- Learning <br><span>Platform</span></h1>
									<div class="btn-col">
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</section> --}}
			<!-- /Home Banner -->
		
			<!-- Page Content -->
			<div class="content">
				<div class="container-fluid bg-white">
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
				<!-- Footer Bottom -->
                <div class="footer-bottom bg-white">
					<div class="container ">
					
						<!-- Copyright -->
						<div class="copyright">
							<div class="row">
								<div class="col-md-6 col-lg-6">
									<div class="copyright-text">
										<p class="mb-0  text-dark">
											<small>© ARAVIND EYECARE SYSTEM</small>
										</p>
									</div>
								</div>
								<div class="col-md-6 col-lg-6">
								
									<!-- Copyright Menu -->
									<div class="copyright-menu">
										<ul class="policy-menu">
											<li><a href="#"><span class="text-dark">Terms and Conditions </span></a></li>
											<li class="text-dark"><a href="#"><span class="text-dark"> Policy </span></a></li>
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

		<!-- Initialize Lottie Animation -->
		<script>
			// Load animation JSON file
			var animationPath = '{{ asset('assets/lottie/doctor-ani.json') }}';

			// Initialize Lottie animation
			var anim = lottie.loadAnimation({
				container: document.getElementById('lottie-animation'),
				renderer: 'svg', // Use 'svg' or 'canvas'
				loop: true,
				autoplay: true,
				path: animationPath
			});
		</script>
			<script>
		 $(document).ready(function() {
    particlesJS('particles-js', {
      "particles": {
        "number": {
          "value": 100,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color": {
          "value": "#ffffff"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          },
          "polygon": {
            "nb_sides": 5
          },
          "image": {
            "src": "img/github.svg",
            "width": 100,
            "height": 100
          }
        },
        "opacity": {
          "value": 0.5,
          "random": false,
          "anim": {
            "enable": false,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 3,
          "random": true,
          "anim": {
            "enable": false,
            "speed": 40,
            "size_min": 0.1,
            "sync": false
          }
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#ffffff",
          "opacity": 0.4,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 6,
          "direction": "none",
          "random": false,
          "straight": false,
          "out_mode": "out",
          "bounce": false,
          "attract": {
            "enable": false,
            "rotateX": 600,
            "rotateY": 1200
          }
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "repulse"
          },
          "onclick": {
            "enable": true,
            "mode": "push"
          },
          "resize": true
        },
        "modes": {
          "grab": {
            "distance": 400,
            "line_linked": {
              "opacity": 1
            }
          },
          "bubble": {
            "distance": 400,
            "size": 40,
            "duration": 2,
            "opacity": 8,
            "speed": 3
          },
          "repulse": {
            "distance": 200,
            "duration": 0.4
          },
          "push": {
            "particles_nb": 4
          },
          "remove": {
            "particles_nb": 2
          }
        }
      },
      "retina_detect": true
    });
  });
		</script>
	</body>
	
</html>


