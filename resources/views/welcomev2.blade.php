<!DOCTYPE html> 
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title> @yield('title')</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets\img\">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css') }}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('/assets/css/font-awesome.min.css') }}">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="{{ asset('/assets/css/feathericon.min.css') }}">
		
		<link rel="stylesheet" href="{{ asset('/assets/plugins/morris/morris.css') }}">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

		<!-- Your HTML content -->

		<!-- Include Lottie Library -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.10/lottie.min.js"></script>
		
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<style>
         /* Full-page overlay */
#punchline-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
     /* India-themed gradient: saffron → white → green */
    background: linear-gradient(
        135deg,
        #FF9933 0%,   /* Saffron */
        #FFFFFF 50%,  /* White */
        #138808 100%  /* Green */
    );
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: all 1.5s ease;
}

/* Punchline text centered initially */
#punchline-text {
    font-size: 32px;
    font-weight: 700;
    text-align: center;
    color: #000;
    transition: all 1.5s ease;
}

/* When shrunk to top */
#punchline-overlay.sticky {
    height: 50px; /* top bar height */
    top: 0;
    left: 0;
    width: 100%;
    justify-content: center;
    align-items: center;
    border-radius: 0;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

#punchline-overlay.sticky #punchline-text {
    font-size: 18px;
}

			h2 {
			text-align: center;
			}
		
		header.header {
				z-index: 1;
				position: relative;
			}

			/* Hero Banner */
            .hero-banner {
                position: relative;
                background: url("{{ asset('homepgast/images/tamilnadu-election-bg.png') }}") center/cover no-repeat;
                min-height: 520px;
                overflow: hidden;
                clip-path: ellipse(100% 80% at 50% 20%);
            }
           
            /* DARK OVERLAY (IMPORTANT) */
           .hero-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;

                background: linear-gradient(
                    rgba(0,0,0,0.65),
                    rgba(0,0,0,0.55)
                );

                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* TEXT BOX */
            .hero-content {
                text-align: center;
                color: white;
                max-width: 100%;
                padding: 0 15px;
                margin: 0 auto;
            }

            .hero-content h1 {
                font-size: 28px;
                font-weight: 700;
                margin-bottom: 10px;
            }

            .hero-content p {
                font-size: 15px;
                opacity: 0.9;
            }

            .glass-card {
                background: rgba(255,255,255,0.92);
                backdrop-filter: blur(12px);
                border-radius: 20px;
            }
			
			/* Hero Banner ends */

			/* Survey Banr Section */
			.survey-cta {
				text-align: center;
				padding: 30px 20px;
				border-radius: 15px;
				margin: 20px auto;
				max-width: 700px;
				box-shadow: 0 10px 25px rgba(0,0,0,0.1);
				}

				.survey-cta h2 {
				font-size: 22px;
				margin-bottom: 10px;
				}

				.survey-cta .tamil {
				font-size: 16px;
				font-weight: 600;
				}

				.survey-cta .english {
				font-size: 14px;
				color: #666;
				margin-top: 5px;
				}

				.survey-count {
				margin: 15px 0;
				font-size: 16px;
				color: #28a745;
				}

				.cta-btn {
				padding: 12px 25px;
				background: linear-gradient(135deg, #dc3545, #28a745);
				color: white;
				border: none;
				border-radius: 30px;
				font-size: 16px;
				cursor: pointer;
				transition: 0.3s;
				}

				.cta-btn:hover {
				transform: scale(1.08);
				box-shadow: 0 8px 20px rgba(0,0,0,0.2);
				}

                .pulse-btn {
                    animation: pulse 1.5s infinite;
                }

                @keyframes pulse {
                    0% { box-shadow: 0 0 0 0 rgba(40,167,69,0.6); }
                    70% { box-shadow: 0 0 0 15px rgba(40,167,69,0); }
                    100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
                }
			/* Survey Banr Section ends */

      

        /* Form Survey */

        form {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            }

            .question {
            margin-bottom: 20px;
            }

           
            .rating {
            display: flex;
            gap: 8px;
            flex-wrap: wrap; /* ✅ KEY FIX */
            justify-content: center;
            }

             .rating label {
            display: flex;
            flex: 1 1 18%;   /* auto adjust */
            text-align: center;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 60px;
            padding: 10px;
            border-radius: 10px;
            font-weight: bold;
            transition: all 0.25s ease;
            }

            /* Number styling */
            .rating .num {
            font-size: 18px;
            }

            /* Text styling */
            .rating .text {
            font-size: 11px;
            margin-top: 3px;
            opacity: 0.9;
            }

            /* Slight emphasis on hover */
            .rating label:hover .text {
            opacity: 1;
            }

            /* Hide radio */
            .rating input {
            display: none;
            }

            /* Base button style */
            .rating label {
            padding: 12px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.25s ease;
            color: white;
            border: none;
            }

            /* Default color scale (VISIBLE always) */
            .rating label:nth-of-type(1) { background: #dc3545; } /* Red */
            .rating label:nth-of-type(2) { background: #fd7e14; } /* Orange */
            .rating label:nth-of-type(3) { background: #ffc107; color: black; } /* Yellow */
            .rating label:nth-of-type(4) { background: #28a745; } /* Light Green */
            .rating label:nth-of-type(5) { background: #218838; } /* Dark Green */

            /* Hover effect */
            .rating label:hover {
            transform: translateY(-3px) scale(1.08);
            filter: brightness(1.15);
            box-shadow: 0 6px 15px rgba(0,0,0,0.2);
            }

            /* Selected state (strong highlight) */
            .rating input:checked + label {
            transform: scale(1.05);
            box-shadow: 0 0 0 3px white, 0 8px 20px rgba(0,0,0,0.3);
            filter: brightness(1.2);
            }

            /* Optional: dim non-selected when one is selected */
            .rating input:checked ~ label {
            opacity: 0.6;
            }

            /* Keep selected fully visible */
            .rating input:checked + label {
            opacity: 1 !important;
            }

            button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            }

            /* form survey ends */
            
            /* Progress bar  */
            #progressBox {
                position: fixed;
                top: 10px;
                left: 50%;
                transform: translateX(-50%);
                width: 320px;
                background: white;
                padding: 10px 15px;
                border-radius: 12px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.15);
                z-index: 9999;
                text-align: center;
                font-weight: bold;
                }

                #progressBar {
                width: 100%;
                height: 8px;
                background: #eee;
                border-radius: 10px;
                margin-top: 5px;
                overflow: hidden;
                }

                #progressFill {
                height: 100%;
                width: 0%;
                background: linear-gradient(90deg, #dc3545, #ffc107, #28a745);
                transition: width 0.3s ease;
                }

                .highlight {
                border: 2px solid red;
                border-radius: 10px;
                padding: 10px;
                }
            /* Progress bar ends */

             .hero-overlay h1 {
                color: #ffffff;
            }


            .survey-cta .tamil {
                font-size: 16px;
                color: #000000;
            }

            .survey-count {
                margin: 15px 0;
                font-size: 16px;
                color: #000000;
            }

            .insight {
                display: block;
                margin-top: 6px;
                font-size: 12px;
                color: #666;
                font-style: italic;
            }

            .party-options {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            .party-options input {
                display: none;
            }

            .party {
                padding: 10px 16px;
                border-radius: 25px;
                color: #fff;
                cursor: pointer;
                font-size: 14px;
                transition: 0.3s;
                border: 2px solid transparent;
            }

            /* Colors */
            .party.bjp { background: #F47216; }
            .party.aiadmk { background: #E31E24; }
            .party.dmk { background: #000000; }
            .party.congress { background: #0000ff; }
            .party.ntk { background: #008000; }
            .party.tvk { background: #FFc107; }

            /* Others (neutral style) */
            .party.others {
                background: #f1f1f1;
                color: #333;
            }

            /* Selected effect */
            .party-options input:checked + .party {
                transform: scale(1.05);
                border: 2px solid #ffffff;
                box-shadow: 0 0 14px 5px #cccccc;
            }


        .footer .footer-top {
            padding-bottom: 0;
        }
       

        .fotrimg {
            position: absolute;
        }

        .lang-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            background: #e0e0e0;
            color: #333;
            cursor: pointer;
            font-size: 14px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        /* Hover */
        .lang-btn:hover {
            background: #cfcfcf;
        }

        /* Active (selected) */
        .lang-btn.active {
            background: #007bff;
            color: #ffffff !important;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {

            #punchline-overlay.sticky #punchline-text {
                font-size: 12px;
            }
              .hero-banner {
                min-height: 720px;
                padding: 20px 0;
            }
            
            .hero-overlay h1 {
                font-size: 22px;
                color: #ffffff;
            }

            form {
                box-shadow: 5px 1px 44px #cccccc;
                padding: 8px;
            }

            

            .rating label {
            flex: 1 1 16%;
            min-width: 40px;
        }

            .question p {
                font-size: 16px;
                font-weight: 700;
            }

            

            .cta-btn {
                width: 100%;
            }

             .survey-cta {
                width: 100%;
                max-width: 100%;
                margin: 10px auto;
                padding: 20px;
                border-radius: 15px;
            }

            #progressBox {
                position: relative;
                margin: 10px auto;
            }

            /* Make SweetAlert inputs responsive on mobile */
            .swal2-popup {
                width: 90% !important;  /* let popup shrink on small screens */
                max-width: 400px;       /* optional max width */
                box-sizing: border-box;
            }

            .swal2-input {
                width: 100% !important;  /* take full width of modal */
                box-sizing: border-box;
                margin: 5px 0;           /* small spacing */
            }
        }

		</style>
    </head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper">
			<!-- Page Content -->
            <!-- Full-page overlay -->
            <div id="punchline-overlay">
                <div id="punchline-text">Make Your Voice Count – Take the TN Election Survey Today!</div>
            </div>

			 <!-- Hero Banner -->
			<div class="hero-banner">
                <div class="hero-overlay">
                    <div class="hero-content">
                        <h1>Share Your Opinion in 30 Seconds</h1>
                        <p>Help improve your community by participating in this quick survey.</p>
                         <div class="survey-cta glass-card inside-hero">
                            <h2>🗳️ உங்கள் கருத்து முக்கியம்!</h2>
                            <p class="tamil">
                                இந்த கருத்துக்கணிப்பில் உங்கள் பதிலை பகிர்ந்து சமூகத்திற்கு உதவுங்கள்.
                            </p>

                            <p class="english">
                                Your opinion matters! Share your feedback and help improve the system.
                            </p>

                            <div class="survey-count">
                                🔥 <b id="surveyCount">5249</b>+ people have already shared their opinion
                                <br>
                                ⏱ Takes less than 30 seconds
                                <br>
                                🔒 100% anonymous & secure
                            </div>

                            <button class="cta-btn pulse-btn" onclick="scrollToForm()">
                                Start Survey Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

           
			<div class="content">
				<div class="container-fluid">
                            <h2>Start Survey</h2>

                            {{-- <div id="progressBox" onclick="goToUnanswered()" style="cursor:pointer;">
                                <div id="progressText">0 / 11 Completed</div>
                                <div id="progressBar">
                                    <div id="progressFill"></div>
                                </div>
                            </div> --}}

                            <div style="text-align:center; margin-bottom:20px;">
                                <button  onclick="setLanguage('en')" id="btn-en" class="lang-btn">English</button>
                                <button  onclick="setLanguage('ta')" id="btn-ta" class="lang-btn">தமிழ்</button>
                            </div>

                            <form id="surveyForm">
                                <!-- Questions 1–10 -->
                                @csrf
                                
                                <div class="question" id="q1-block">
                                    <p id="q1-text">
                                        1. உங்களுக்கு சொல்லிய பணம் / உதவிகள் நேரத்திற்கு கிடைக்கிறதா?
                                        <br>
                                        <small>Are you receiving the money/benefits promised to you on time?</small>
                                    </p>
                                    <div class="rating">
                                    <input type="radio" id="q1-1" name="q1" value="1" required>
                                    <label for="q1-1">
                                        <span class="num">1</span>
                                        <span class="text">Poor</span>
                                    </label>
                                    <input type="radio" id="q1-2" name="q1" value="2">
                                    <label for="q1-2">
                                        <span class="num">2</span>
                                        <span class="text">Low</span>
                                    </label>

                                    <input type="radio" id="q1-3" name="q1" value="3">
                                    <label for="q1-3">
                                        <span class="num">3</span>
                                        <span class="text">Average</span>
                                    </label>

                                    <input type="radio" id="q1-4" name="q1" value="4">
                                    <label for="q1-4">
                                        <span class="num">4</span>
                                        <span class="text">Good</span>
                                    </label>

                                    <input type="radio" id="q1-5" name="q1" value="5">
                                    <label for="q1-5">
                                        <span class="num">5</span>
                                        <span class="text">Excellent</span>
                                    </label>
                                </div>
                                <small class="insight" id="q1-insight"></small>
                                </div>

                                <!-- Q2 -->
                                <div class="question" id="q2-block">
                                <p id="q2-text">
                                    2. உங்கள் பகுதியில் சாலை, வடிகால் வசதிகள் சரியாக உள்ளதா?
                                    <br>
                                    <small>Are roads and drainage facilities in your area in good condition?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q2-1" name="q2" value="1" required><label for="q2-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q2-2" name="q2" value="2"><label for="q2-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q2-3" name="q2" value="3"><label for="q2-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q2-4" name="q2" value="4"><label for="q2-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q2-5" name="q2" value="5"><label for="q2-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                    
                                </div>
                                <small class="insight" id="q2-insight"></small>
                                </div>

                                <!-- Q3 -->
                                <div class="question" id="q3-block">
                                <p id="q3-text">
                                    3.	அரசு வேலை கிடைக்கும் நடைமுறை நேர்மையாக இருக்கிறதா?
                                    <br>
                                    <small>Is the process of getting government jobs fair?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q3-1" name="q3" value="1" required><label for="q3-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q3-2" name="q3" value="2"><label for="q3-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q3-3" name="q3" value="3"><label for="q3-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q3-4" name="q3" value="4"><label for="q3-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q3-5" name="q3" value="5"><label for="q3-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q3-insight"></small>
                                </div>

                                <!-- Q4 -->
                                <div class="question" id="q4-block">
                                <p id="q4-text">
                                    4.	TNPSC தேர்வுகள் நம்பிக்கைக்குரிய முறையில் நடக்கிறதா?
                                    <br>
                                    <small>Do you feel TNPSC exams are conducted in a trustworthy manner?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q4-1" name="q4" value="1" required><label for="q4-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q4-2" name="q4" value="2"><label for="q4-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q4-3" name="q4" value="3"><label for="q4-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q4-4" name="q4" value="4"><label for="q4-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q4-5" name="q4" value="5"><label for="q4-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q4-insight"></small>
                                </div>

                                <!-- Q5 -->
                                <div class="question" id="q5-block">
                                <p id="q5-text">
                                    5.	உங்கள் பகுதியில் பெண்களுக்கு பாதுகாப்பு இருக்கிறதா?
                                    <br>
                                    <small>Do women feel safe in your area?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q5-1" name="q5" value="1" required><label for="q5-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q5-2" name="q5" value="2"><label for="q5-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q5-3" name="q5" value="3"><label for="q5-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q5-4" name="q5" value="4"><label for="q5-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q5-5" name="q5" value="5"><label for="q5-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q5-insight"></small>
                                </div>

                                <!-- Q6 -->
                                <div class="question" id="q6-block">
                                <p id="q6-text">
                                    6.	சாதி அடிப்படையிலான வன்முறை இல்லாமல் மக்கள் பாதுகாப்பாக இருக்கிறார்களா?
                                    <br>
                                    <small>Do people feel safe without caste-based violence in your area?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q6-1" name="q6" value="1" required><label for="q6-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q6-2" name="q6" value="2"><label for="q6-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q6-3" name="q6" value="3"><label for="q6-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q6-4" name="q6" value="4"><label for="q6-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q6-5" name="q6" value="5"><label for="q6-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q6-insight"></small>
                                </div>

                                <!-- Q7 -->
                                <div class="question" id="q7-block">
                                <p id="q7-text">
                                    7.	குழந்தைகள் பாதுகாப்பாக இருக்கிறார்கள் என்று உங்களுக்கு நிம்மதி உள்ளதா?
                                    <br>
                                    <small>Do you feel children are safe?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q7-1" name="q7" value="1" required><label for="q7-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q7-2" name="q7" value="2"><label for="q7-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q7-3" name="q7" value="3"><label for="q7-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q7-4" name="q7" value="4"><label for="q7-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q7-5" name="q7" value="5"><label for="q7-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q7-insight"></small>
                                </div>

                                <!-- Q8 -->
                                <div class="question" id="q8-block">
                                <p id="q8-text">
                                    8.	கோவில்கள் நன்றாக பராமரிக்கப்படுகிறதா?
                                    <br>
                                    <small>Are temples being maintained properly?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q8-1" name="q8" value="1" required><label for="q8-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q8-2" name="q8" value="2"><label for="q8-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q8-3" name="q8" value="3"><label for="q8-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q8-4" name="q8" value="4"><label for="q8-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q8-5" name="q8" value="5"><label for="q8-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q8-insight"></small>
                                </div>

                                <!-- Q9 -->
                                <div class="question" id="q9-block">
                                <p id="q9-text">
                                    9.	கேஸ் சலுகை மற்றும் பிற உதவிகள் சரியாக கிடைக்கிறதா?
                                    <br>
                                    <small>Are gas subsidies and other benefits reaching you properly?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q9-1" name="q9" value="1" required><label for="q9-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q9-2" name="q9" value="2"><label for="q9-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q9-3" name="q9" value="3"><label for="q9-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q9-4" name="q9" value="4"><label for="q9-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q9-5" name="q9" value="5"><label for="q9-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q9-insight"></small>
                                </div>

                                <!-- Q10 -->
                                <div class="question" id="q10-block">
                                <p id="q10-text">
                                    10.	மொத்தத்தில், தற்போதைய ஆட்சியில் நீங்கள் திருப்தியாக உள்ளீர்களா?
                                    <br>
                                    <small>Overall, are you satisfied with the current government?</small>
                                </p>
                                <div class="rating">
                                    <input type="radio" id="q10-1" name="q10" value="1" required><label for="q10-1"><span class="num">1</span><span class="text">Poor</span></label>
                                    <input type="radio" id="q10-2" name="q10" value="2"><label for="q10-2"><span class="num">2</span><span class="text">Low</span></label>
                                    <input type="radio" id="q10-3" name="q10" value="3"><label for="q10-3"><span class="num">3</span><span class="text">Average</span></label>
                                    <input type="radio" id="q10-4" name="q10" value="4"><label for="q10-4"><span class="num">4</span><span class="text">Good</span></label>
                                    <input type="radio" id="q10-5" name="q10" value="5"><label for="q10-5"><span class="num">5</span><span class="text">Excellent</span></label>
                                </div>
                                <small class="insight" id="q10-insight"></small>
                                </div>


                                <!-- Question 11 -->
                                <div class="question" id="q11-block">
                                    <p id="q11-text">
                                        11. நல்ல மாற்றத்திற்காக நீங்கள் எந்த கட்சியை தேர்வு செய்வீர்கள்?
                                        <br>
                                        <small>Which party would you choose for a better change?</small>
                                    </p>
                                    <div class="party-options">
                                    <input type="radio" id="party-bjp" name="q11" value="BJP" required>
                                    <label for="party-bjp" class="party bjp">BJP</label>

                                    <input type="radio" id="party-aiadmk" name="q11" value="AIADMK">
                                    <label for="party-aiadmk" class="party aiadmk">AIADMK</label>

                                    <input type="radio" id="party-dmk" name="q11" value="DMK">
                                    <label for="party-dmk" class="party dmk">DMK</label>

                                    <input type="radio" id="party-congress" name="q11" value="Congress">
                                    <label for="party-congress" class="party congress">Congress</label>
                                    
                                    <input type="radio" id="party-ntk" name="q11" value="NTK">
                                    <label for="party-ntk" class="party ntk">NTK</label>

                                    <input type="radio" id="party-tvk" name="q11" value="TVK">
                                    <label for="party-tvk" class="party tvk">TVK</label>

                                    <input type="radio" id="party-others" name="q11" value="Others">
                                    <label for="party-others" class="party others">Others</label>
                                </div>
                            </div>
                            <small class="insight" id="q11-insight"></small>

                                <button type="submit" class="cta-btn pulse-btn" onclick="goToUnanswered()">Submit Survey</button>
                                </form>

				</div>
			</div>		
			<!-- /Page Content -->
		</div>
		<!-- /Main Wrapper -->
	  
		<!-- jQuery -->
		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>
		
		<!-- Custom JS -->
		<script src="{{ asset('assets/js/script.js') }}"></script>
        
		<!-- Sweet alert -->
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	</body>

    <script>
const totalQuestions = 11;

function updateProgress() {
  let answered = 0;

  // Count radio questions (q1–q10)
  for (let i = 1; i <= 10; i++) {
    if (document.querySelector(`input[name="q${i}"]:checked`)) {
      answered++;
    }
  }

  // Check dropdown
  const q11 = document.querySelector('select[name="q11"]');
  if (q11 && q11.value !== "") {
    answered++;
  }

  // Update UI
  document.getElementById("progressText").innerText = `${answered} / ${totalQuestions} Completed`;
  document.getElementById("progressFill").style.width = (answered / totalQuestions) * 100 + "%";
}

// Listen to changes
document.querySelectorAll('input, select').forEach(el => {
  el.addEventListener('change', updateProgress);
});
</script>

<script>
function goToUnanswered() {

  // Remove old highlights FIRST (cleaner)
  document.querySelectorAll('.question').forEach(q => q.classList.remove('highlight'));

  // Check q1–q10
  for (let i = 1; i <= 10; i++) {
    if (!document.querySelector(`input[name="q${i}"]:checked`)) {
      
      let target = document.getElementById(`q${i}-block`);
      
      target.scrollIntoView({ behavior: 'smooth', block: 'center' });
      target.classList.add('highlight');

      return;
    }
  }

  // Check dropdown (q11)
  const q11 = document.querySelector('select[name="q11"]');
  if (q11 && q11.value === "") {
    
    let target = document.getElementById("q11-block");
    
    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
    target.classList.add('highlight');

    return;
  }

  // If all done
//   alert("All questions completed ✅");
}
</script>



<script>
document.getElementById("surveyForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    // Show loading
    Swal.fire({
        title: 'Submitting...',
        text: 'Please wait while we submit your response',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('{{ route('surveysubmit') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        },
        body: formData
    })
    .then(res => res.json())
	.then(data => {
		console.log("Main API response:", data);

		// Step 1: Show count + ask for details
		Swal.fire({
			icon: 'success',
			title: 'Thank You! ',
			html: `
				<p>Your response has been submitted successfully.</p>
				<p><b>${data.count}</b> people have already participated.</p>
				<br>
				<p>Would you like to share your name & number for social responsibility? (Optional)</p>
			`,
			showCancelButton: true,
			confirmButtonText: 'Yes, I will share',
			cancelButtonText: 'Skip'
		}).then(result => {

			if (result.isConfirmed) {

				// Step 2: Ask for name & phone
				Swal.fire({
					title: 'Your Details (Optional)',
					html: `
						<input type="text" id="swal-name" class="swal2-input" placeholder="Your Name">
						<input type="text" id="swal-phone" class="swal2-input" placeholder="Phone Number">
					`,
					confirmButtonText: 'Submit',
					showCancelButton: true,
					preConfirm: () => {
						return {
							name: document.getElementById('swal-name').value,
							phone: document.getElementById('swal-phone').value
						};
					}
				}).then(res => {

					if (res.isConfirmed) {

						fetch('{{ route('surveyuserdetails') }}', {
							method: 'POST',
							headers: {
								'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
								'Content-Type': 'application/json'
							},
							body: JSON.stringify({
								survey_id: data.survey_id,
								name: res.value.name,
								phone: res.value.phone
							})
						})
						.then(() => {
							Swal.fire({
								icon: 'success',
								title: 'Thank You ',
								text: 'Your details have been saved.'
							});
						});
					}
				});

			} else {
				Swal.fire({
					icon: 'success',
					title: 'Thank You ',
					text: 'Your response means a lot!'
				});
			}

		});

		form.reset();
	})
    .catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong. Please try again.'
        });
    });
});
</script>

<script>
function scrollToForm() {
    document.getElementById("surveyForm")
        .scrollIntoView({ behavior: 'smooth' });
}
</script>

<script>
fetch('/survey-count')
.then(res => res.json())
.then(data => {
    document.getElementById('surveyCount').innerText = data.count;
});
</script>


<script>
const content = {
    en: {
        q1: "1. Are you receiving the money/benefits promised to you on time?",
        q2: "2. Are roads and drainage facilities in your area in good condition?",
        q3: "3. Is the process of getting government jobs fair?",
        q4: "4. Do you feel TNPSC exams are conducted in a trustworthy manner?",
        q5: "5. Do women feel safe in your area?",
        q6: "6. Do people feel safe without caste-based violence in your area?",
        q7: "7. Do you feel children are safe?",
        q8: "8. Are temples being maintained properly?",
        q9: "9. Are gas subsidies and other benefits reaching you properly?",
        q10: "10. Overall, are you satisfied with the current government?",
        q11: "11. Which party would you choose for a better change?",
        submit: "Submit Survey"
    },
    ta: {
        q1: "1. உங்களுக்கு சொல்லிய பணம் / உதவிகள் நேரத்திற்கு கிடைக்கிறதா?",
        q2: "2. உங்கள் பகுதியில் சாலை, வடிகால் வசதிகள் சரியாக உள்ளதா?",
        q3: "3. அரசு வேலை கிடைக்கும் நடைமுறை நேர்மையாக இருக்கிறதா?",
        q4: "4. TNPSC தேர்வுகள் நம்பிக்கைக்குரிய முறையில் நடக்கிறதா?",
        q5: "5. உங்கள் பகுதியில் பெண்களுக்கு பாதுகாப்பு இருக்கிறதா?",
        q6: "6. சாதி அடிப்படையிலான வன்முறை இல்லாமல் மக்கள் பாதுகாப்பாக இருக்கிறார்களா?",
        q7: "7. குழந்தைகள் பாதுகாப்பாக இருக்கிறார்கள் என்று உங்களுக்கு நிம்மதி உள்ளதா?",
        q8: "8. கோவில்கள் நன்றாக பராமரிக்கப்படுகிறதா?",
        q9: "9. கேஸ் சலுகை மற்றும் பிற உதவிகள் சரியாக கிடைக்கிறதா?",
        q10: "10. மொத்தத்தில், தற்போதைய ஆட்சியில் நீங்கள் திருப்தியாக உள்ளீர்களா?",
        q11: "11. நல்ல மாற்றத்திற்காக நீங்கள் எந்த கட்சியை தேர்வு செய்வீர்கள்?",
        submit: "சமர்ப்பிக்கவும்"
    }
};

const insights = {
    en: {
        q1: "Most people rated 3",
        q2: "Most people rated 5",
        q3: "Most people rated 2",
        q4: "Most people rated 3",
        q5: "Most people rated 4",
        q6: "Most people rated 3",
        q7: "Most people rated 4",
        q8: "Most people rated 4",
        q9: "Most people rated 3",
        q10: "Most people rated 2",
        q11: ""
    },
    ta: {
        q1: "பலர் 3 மதிப்பீடு அளித்துள்ளனர்",
        q2: "பலர் 5 மதிப்பீடு அளித்துள்ளனர்",
        q3: "பலர் 2 மதிப்பீடு அளித்துள்ளனர்",
        q4: "பலர் 3 மதிப்பீடு அளித்துள்ளனர்",
        q5: "பலர் 4 மதிப்பீடு அளித்துள்ளனர்",
        q6: "பலர் 3 மதிப்பீடு அளித்துள்ளனர்",
        q7: "பலர் 4 மதிப்பீடு அளித்துள்ளனர்",
        q8: "பலர் 4 மதிப்பீடு அளித்துள்ளனர்",
        q9: "பலர் 3 மதிப்பீடு அளித்துள்ளனர்",
        q10: "பலர் 2 மதிப்பீடு அளித்துள்ளனர்",
        q11: ""
    }
};

function setLanguage(lang) {
    for (let i = 1; i <= 11; i++) {
        document.getElementById(`q${i}-text`).innerHTML = content[lang][`q${i}`];

        if (document.getElementById(`q${i}-insight`)) {
            document.getElementById(`q${i}-insight`).innerText = insights[lang][`q${i}`] || "";
        }
    }

    document.querySelector("button[type='submit']").innerText = content[lang].submit;

    // Button highlight
    document.getElementById("btn-en").style.background = lang === 'en' ? "#007bff" : "#ccc";
    document.getElementById("btn-ta").style.background = lang === 'ta' ? "#007bff" : "#ccc";
}

// Default load
window.onload = function () {
    setLanguage('ta');
};
</script>

<script>
window.addEventListener('load', () => {
    const overlay = document.getElementById('punchline-overlay');

    // Wait 2 seconds, then shrink to top
    setTimeout(() => {
        overlay.classList.add('sticky');
    }, 2000);

    // Optional: remove overlay completely after another 2 seconds
    setTimeout(() => {
        overlay.style.position = 'relative'; // keep sticky top
        overlay.style.height = '50px';
    }, 3500);
});
</script>
</html>
