@extends('layouts.campexe.master')

@section('content')
<!-- Page Wrapper -->
<style>
    /*form styles*/
    #msform {
        text-align: center;
        position: relative;
        margin-top: 20px;
    }

    #msform fieldset .form-card {
        background: white;
        border: 0 none;
        border-radius: 0px;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        padding: 20px 40px 30px 40px;
        box-sizing: border-box;
        width: 94%;
        margin: 0 3% 20px 3%;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    #msform fieldset {
        background: white;
        border: 0 none;
        border-radius: 0.5rem;
        box-sizing: border-box;
        width: 100%;
        margin: 0;
        padding-bottom: 20px;

        /*stacking fieldsets above each other*/
        position: relative;
    }

    /*Hide all except first fieldset*/
    #msform fieldset:not(:first-of-type) {
        display: none;
    }

    #msform fieldset .form-card {
        text-align: left;
        color: #9E9E9E;
    }

    #msform input, #msform textarea {
        padding: 0px 8px 4px 8px;
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0px;
        margin-bottom: 25px;
        margin-top: 2px;
        width: 26%;
        box-sizing: border-box;
        font-family: montserrat;
        color: #2C3E50;
        font-size: 16px;
        letter-spacing: 1px;
    }

    #msform input:focus, #msform textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: none;
        font-weight: bold;
        border-bottom: 2px solid #0168b3;
        outline-width: 0;
    }

    /*Blue Buttons*/
    #msform .action-button {
        width: 100px;
        background: #0168b3;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button:hover, #msform .action-button:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #0168b3;
    }

    /*Previous Buttons*/
    #msform .action-button-previous {
        width: 100px;
        background: #616161;
        font-weight: bold;
        color: white;
        border: 0 none;
        border-radius: 0px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 10px 5px;
    }

    #msform .action-button-previous:hover, #msform .action-button-previous:focus {
        box-shadow: 0 0 0 2px white, 0 0 0 3px #616161;
    }

    /*Dropdown List Exp Date*/
    select.list-dt {
        border: none;
        outline: 0;
        border-bottom: 1px solid #ccc;
        padding: 2px 5px 3px 5px;
        margin: 2px;
    }

    select.list-dt:focus {
        border-bottom: 2px solid #0168b3;
    }

    /*The background card*/
    .card {
        z-index: 0;
        border: none;
        border-radius: 0.5rem;
        position: relative;
    }

    /*FieldSet headings*/
    .fs-title {
        font-size: 25px;
        color: #2C3E50;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: left;
    }

    /*progressbar*/
    #progressbar {
        margin-bottom: 30px;
        overflow: hidden;
        color: lightgrey;
    }

    #progressbar .active {
        color: #000000;
    }

    #progressbar li {
        list-style-type: none;
        font-size: 12px;
        width: 7%;
        float: left;
        position: relative;
    }

    /*Icons in the ProgressBar*/
    #progressbar #account:before {
        font-family: FontAwesome;
        content: "\f13e";
    }

    #progressbar .completed:before {
        font-family: FontAwesome;
        content: "\f046" !important;
    }

    #progressbar #personal:before {
        font-family: FontAwesome;
        content: "\f007";
    }

    #progressbar #payment:before {
        font-family: FontAwesome;
        content: "\f09d";
    }

    #progressbar #confirm:before {
        font-family: FontAwesome;
        content: "\f00c";
    }

    /*ProgressBar before any progress*/
    #progressbar li:before {
        width: 50px;
        height: 50px;
        line-height: 45px;
        display: block;
        font-size: 18px;
        color: #ffffff;
        background: lightgray;
        border-radius: 50%;
        margin: 0 auto 10px auto;
        padding: 2px;
    }

    /*ProgressBar connectors*/
    #progressbar li:after {
        content: '';
        width: 100%;
        height: 2px;
        background: lightgray;
        position: absolute;
        left: 0;
        top: 25px;
        z-index: -1;
    }

    /*Color number of the step and the connector before it*/
    #progressbar li.completed:before, #progressbar li.completed:after {
        background: #23a242;
    }
    
    #progressbar li.active:before, #progressbar li.active:after {
        background: #0168b3;
    }

    /*Imaged Radio Buttons*/
    .radio-group {
        position: relative;
        margin-bottom: 25px;
    }

    .radio {
        display:inline-block;
        width: 204;
        height: 104;
        border-radius: 0;
        background: lightblue;
        box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
        box-sizing: border-box;
        cursor:pointer;
        margin: 8px 2px; 
    }

    .radio:hover {
        box-shadow: 2px 2px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .radio.selected {
        box-shadow: 1px 1px 2px 2px rgba(0, 0, 0, 0.1);
    }

    /*Fit image in bootstrap div*/
    .fit-image{
        width: 100%;
        object-fit: cover;
    }

    /*Feedback form*/

    .funkyradio div {
    clear: both;
    overflow: hidden;
    }

    .funkyradio label {
    width: 100%;
    border-radius: 3px;
    border: 1px solid #D1D3D4;
    font-weight: normal;
    }

    .funkyradio input[type="radio"]:empty {
    display: none;
    }

    .funkyradio input[type="radio"]:empty ~ label{
    position: relative;
    line-height: 2.5em;
    text-indent: 3.25em;
    margin-top: 0.6em;
    cursor: pointer;
    -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;
    }

    .funkyradio input[type="radio"]:empty ~ label:before {
    position: absolute;
    display: block;
    top: 0;
    bottom: 0;
    left: 0;
    content: '';
    width: 2.5em;
    background: #D1D3D4;
    border-radius: 3px 0 0 3px;
    }

    .funkyradio input[type="radio"]:hover:not(:checked) ~ label {
    color: #888;
    }

    .funkyradio input[type="radio"]:hover:not(:checked) ~ label:before {
    content: '\2714';
    text-indent: .9em;
    color: #C2C2C2;
    }

    .funkyradio input[type="radio"]:checked ~ label {
    color: #777;
    }

    .funkyradio input[type="radio"]:checked ~ label:before {
    content: '\2714';
    text-indent: .9em;
    color: #333;
    background-color: #ccc;
    }

    .funkyradio input[type="radio"]:focus ~ label:before {
    box-shadow: 0 0 0 3px #999;
    }

    .funkyradio-default input[type="radio"]:checked ~ label:before {
    color: #333;
    background-color: #ccc;
    }

    .funkyradio-primary input[type="radio"]:checked ~ label:before {
    color: #fff;
    background-color: #337ab7;
    }

</style>
<div class="page-wrapper">
			
    <div class="content container-fluid">
        
        <!-- Page Header -->
        <div class="page-header">
            @if (Session::get('fail'))
                <div class="alert alert-danger">
                    {!! Session::get('fail')  !!}
                </div>
            @endif
               
            @if (Session::get('danger'))
                <div class="alert alert-danger">
                    {!! Session::get('danger')  !!}
                </div>
            @endif
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {!! Session::get('success')  !!}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="row">
                <div class="col-sm-4">
                    <h3 class="page-title">Welcome  {{ Auth::user()->name }} ! </h3>
                </div>
                <div class="col-sm-4">
                    @php
                        // Initialize a flag to track if the active module has been found
                        $TotalmoduleCount_mainprogress = 0;
                        $moduleCompletedCount_mainprogress = 0;
                    @endphp

                    @for ($i_mainprogress = 1; $i_mainprogress <= 15; $i_mainprogress++)
                        @if ($registered_course_detail["module_$i_mainprogress"])
                            @php
                                
                                // Check if the module is completed
                                $TotalmoduleCount_mainprogress ++;

                                // Check if the module is completed
                                if( $registered_course_detail["module_${i_mainprogress}_completed"] == 'yes'){
                                        $moduleCompletedCount_mainprogress ++; 
                                    }

                                // If the active module has not been found and the current module is not completed, mark it as active
                            
                            @endphp
                        @endif
                    @endfor

                

                    @php
                        // Calculate the percentage of modules completed
                        $percentageCompleted = ($moduleCompletedCount_mainprogress / $TotalmoduleCount_mainprogress) * 100;
                    @endphp
                    
                    Modules Completed: <span class="text-success">{{ $moduleCompletedCount_mainprogress }}/{{ $TotalmoduleCount_mainprogress }}</span> <span class="text-danger"> ({{ intval($percentageCompleted) }}%) </span>
                </div>
                
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-md-12">
                
            <!--@if(session('correctCount') && session('percentage'))-->
            <!--    <div class="alert alert-success" role="alert">-->
            <!--        Number of correct responses: {{ session('correctCount') }}-->
            <!--    </div>-->
            <!--    <div class="alert alert-info" role="alert">-->
            <!--        Your percentage is: {{ session('percentage') }} %-->
            <!--    </div>-->
            <!--@endif-->
            </div>
        </div>

        {{-- Test  --}}
        <div class="container-fluid" id="grad1">
            <div class="row justify-content-center mt-0">
                <div class="col-md-12 ">
                    <div class="card px-0  mb-0">
                        <div class="row">
                            <div class="col-md-12 mx-0">
                                <div id="msform">
                                    <ul id="progressbar">
                                        @php
                                            // Initialize a flag to track if the active module has been found
                                            $activeModuleFound = false;
                                            $TotalmoduleCount = 0;
                                            $moduleCompletedCount = 0;
                                        @endphp

                                        @for ($i = 1; $i <= 15; $i++)
                                            @if ($registered_course_detail["module_$i"])
                                                @php
                                                    // Run SQL query to fetch resource data from the 'resources' table
                                                    $resourceData = DB::select("SELECT * FROM resources WHERE id = ?", [$registered_course_detail["module_$i"]]);

                                                    // Check if the module is completed
                                                    $moduleCompleted = $registered_course_detail["module_${i}_completed"] == 'yes';
                                                    $TotalmoduleCount ++;

                                                    if( $registered_course_detail["module_${i}_completed"] == 'yes'){
                                                        $moduleCompletedCount ++; 
                                                    }

                                                    // If the active module has not been found and the current module is not completed, mark it as active
                                                    if (!$activeModuleFound && !$moduleCompleted) {
                                                        $activeModuleFound = true;
                                                        $moduleClass = 'active';
                                                    } elseif ($moduleCompleted) {
                                                        $moduleClass = 'completed';
                                                    } else {
                                                        $moduleClass = 'upcoming';
                                                    }
                                                @endphp

                                                <li class="{{ $moduleClass }}" id="account">
                                                    <strong>Module: {{ $i }}</strong>
                                                </li>
                                                                                        
                                                <li class="{{ $moduleClass }}" id="account">
                                                    <strong>Module: {{ $i }} | Quiz</strong>
                                                </li>
                                            @endif
                                        @endfor

                                        @php
                                        if ($moduleCompletedCount == $TotalmoduleCount) {
                                            $moduleStyleFinalClass = 'completed';
                                        }else{
                                            $moduleStyleFinalClass = '';
                                        }
                                    @endphp
                                         <li class="{{ $moduleStyleFinalClass }}" id="confirm"><strong>Finish</strong></li>
                                    </ul>
                                    <!-- fieldsets -->

                                    @php
                                        // Initialize a flag to track if the active module has been found
                                        $activeModuleFieldsetFound = false;
                                        
                                    @endphp

                                    @for ($i = 1; $i <= 15; $i++)
                                            @if ($registered_course_detail["module_$i"])

                                                @php
                                                    // Run SQL query to fetch resource data from the 'resources' table
                                                    $resourceData = DB::select("SELECT * FROM resources WHERE id = ?", [$registered_course_detail["module_$i"]]);
                                        
                                                    // Check if the module is completed
                                                    $moduleCompleted = $registered_course_detail["module_${i}_completed"] == 'yes';
                                        
                                                     // If the active module has not been found and the current module is not completed, mark it as active
                                                        if (!$activeModuleFieldsetFound && !$moduleCompleted) {
                                                            $activeModuleFieldsetFound = true;
                                                            $moduleStyle = 'opacity: 1; position: relative; display: block;';
                                                        } elseif ($moduleCompleted) {
                                                            $moduleStyle = 'opacity: 0; position: relative; display: none;';
                                                        } else {
                                                            $moduleStyle = 'opacity: 0; position: relative; display: none;';
                                                        }
                                                @endphp
                                                <fieldset style="{{ $moduleStyle  }}" class="section-{{ $i }}">
                                                    <div class="form-card" >
                                                        @php
                                                            // Run SQL query to fetch resource data from the 'resources' table
                                                            $resourceData = DB::select("SELECT * FROM resources WHERE id = ?", [$registered_course_detail["module_$i"]]);
                                                        @endphp

                                                        @if (!empty($resourceData) && $resourceData[0]->resource_type == 'video')

                                                            <div class="form-group row justify-content-center">
                                                                <div class="col-md-10">
                                                                    <div style='position:relative;height:0;padding-bottom:56.25%'>
                                                                        
                                                                        @php
                                                                            $iframeHtml = $resourceData[0]->resource_path;
                                                                            $modifiedIframeHtml = preg_replace(['/width=["\']\d+["\']/', '/height=["\']\d+["\']/'], ['style="position:absolute;width:100%;height:100%;left:0;top:0"', ''], $iframeHtml);
                                                                        @endphp

                                                                        {!! $modifiedIframeHtml !!}
                                                               
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    @if ($i > 1) <!-- Show the "Previous" button only if it's not the first iteration -->
                                                        <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                                                    @endif

                                                    <input type="button" name="next" class="next action-button" value="Next Step"/>
                                                </fieldset>
                                                <fieldset>
                                                    <div class="mcq">
                                                        <div class="container">
                                                            @if ($i == 1)
                                                                @php $ModuleHeading = 'Fantastic! You’ve completed Module 1, aim for that 50% and beyond!'; @endphp
                                                            @elseif ($i == 2)
                                                                @php $ModuleHeading = 'Amazing! Stay focused and reach that 50% score, you\'ve got this!'; @endphp
                                                            @elseif ($i == 3)
                                                                @php $ModuleHeading = 'It\'s halfway to success! Keep going and strive for that 50% achievement!'; @endphp
                                                            @elseif ($i == 4)
                                                                @php $ModuleHeading = 'Doing great! Keep up the effort and reach that 50% milestone!'; @endphp
                                                            @elseif ($i == 5)
                                                                @php $ModuleHeading = 'You\'re on the right track! Keep going strong to achieve that 50% score!'; @endphp
                                                            @elseif ($i == 6)
                                                                @php $ModuleHeading = 'Almost there! Keep pushing forward and aim high for that 50% score!'; @endphp
                                                            @else
                                                                @php $ModuleHeading = ''; @endphp
                                                            @endif

                                                            <h2 class="text-success text-left">{{ $ModuleHeading }}</h2>

                                                            <h6 class="card-title text-left">MCQ Section |  Attempt No : <span class="text-danger">{{ $registered_course_detail["module_${i}_attempt"]  }} </span></h6>
                                                            @if ($registered_course_detail["module_${i}_completed"] == 'yes')
                                                                    <div class="alert alert-success" role="alert">
                                                                        Module {{ $i }} completed successfully 
                                                                    </div>
                                                            @else
                                                                <form id="mcqForm{{$i}}" action={{ route('user.submit_course_result_v2') }} method="POST">
                                                                    <input type="hidden" name="module_name" value="module_{{ $i }}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        @if ([$registered_course_detail["module_{$i}_quiz"]])
                                                                            @php
                                                                                $module_pareent_mcq_count = 0;
                                                                            @endphp    
                                                                        @foreach(json_decode($registered_course_detail["module_{$i}_quiz"], true)['mcqs'] as $question)
                                                                            @php
                                                                                $module_pareent_mcq_count ++;
                                                                            @endphp        
                                                                        <div class="col-md-4">
                                                                                    <div class="form-group text-left">
                                                                                        <p>{{ $question['question'] }}</p>
                                                                                    </div>
                                                                                    <div class="form-group text-left">
                                                                                        <label class="col-form-label ">Options</label>
                                                                                        <div class="">
                                                                                            @php
                                                                                                $modulemcqno = 0;
                                                                                            @endphp
                                                                                            @foreach($question['options'] as $option)
                                                                                                @php
                                                                                                    $modulemcqno ++;
                                                                                                @endphp
                                                                                                <div class="form-check">
                                                                                                    <input class="form-check-input" type="radio" name="module_{{$i}}_quiz[mcq_{{ $module_pareent_mcq_count }}_user_selected]" id="option_{{ $module_pareent_mcq_count }}" value="{{ $modulemcqno }}" data-analog-resid="{{ $question['correct_answer'] }}" required>
                                                                                                    <label class="form-check-label" for="option_{{ $module_pareent_mcq_count }}">
                                                                                                        {{ $option }}
                                                                                                    </label>
                                                                                                    
                                                                                                </div>
                                                                                            @endforeach
                                                                                                Correct answer : {{ $question['correct_answer'] }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>  
                                                                            @endforeach
                                                                            <div class="col-md-12">
                                                                                <button type="submit" class="btn btn-block btn-primary submit-mcq" data-module="{{$i}}">Submit</button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </form>
                                                            @endif

                                                            
                                                        </div>
                                                    </div>
                                                    <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>

                                                    @if ($registered_course_detail["module_${i}_completed"] == 'yes')
                                                        <input type="button" name="next" class="next action-button" value="Next Step"/>
                                                    @endif

                                                </fieldset>
                                            @endif
                                    @endfor
                                    @php
                                        if ($moduleCompletedCount == $TotalmoduleCount) {
                                            $moduleStyleFinal = 'opacity: 1; position: relative; display: block;';
                                        }else{
                                            $moduleStyleFinal = '';
                                        }
                                    @endphp
                                    <fieldset style="{{ $moduleStyleFinal }}">
                                        
                                        @if ($moduleCompletedCount == $TotalmoduleCount)
                                            <div class="form-card" style="$moduleStyleFinal">
                                                <div class="row justify-content-center">
                                                    <div class="col-5">
                                                        <img src="{{ asset('assets/img/Congratulations.jpg') }}" class="fit-image">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        {{-- Test End --}}

        {{-- Intro User  modal --}}
            <div class="modal fade" id="user_intro_modal___" aria-hidden="true" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="form-content p-2">
                                <h3 class="modal-title">Hi {{ Auth::user()->name }} !  | Welcome to Trivia</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="quiz-container">
                                            <h4 class="bg-primary text-white text-center">Your Daily Quiz</h4>
                                            @php
                                                // Run SQL query to fetch resource data from the 'resources' table
                                                $dailyQuizData = \App\Models\DailyQuiz::find(1);
                                            @endphp
                                             @if ($dailyQuizData)

                                                @if ($dailyQuizData->quiz_type ==  'mcq')
                                                    <form id="smallquizform">
                                                        <div class="question">
                                                            <h5>Q: {{ $dailyQuizData->question }}</h5>
                                                            <label><input type="radio" name="q1" value="{{ $dailyQuizData->option1 }}"> {{ $dailyQuizData->option1 }}</label><br>
                                                            <label><input type="radio" name="q1" value="{{ $dailyQuizData->option2 }}"> {{ $dailyQuizData->option2 }}</label><br>
                                                            <label><input type="radio" name="q1" value="{{ $dailyQuizData->option3 }}"> {{ $dailyQuizData->option3 }}</label><br>
                                                            <label><input type="radio" name="q1" value="{{ $dailyQuizData->option4 }}"> {{ $dailyQuizData->option4 }}</label><br>
                                                        </div>
                                                        <!-- Add more questions here -->
                                                        <button type="button" class="btn btn-block btn-danger" id="smallquizsubmit">Submit</button>
                                                    </form>  
                                                    
                                                    <div id="result-container" style="display: none;">
                                                        <h2>Result</h2>
                                                        <p id="result"></p>
                                                        <p id="explanation"></p>
                                                    </div>
                                                @endif
                                               
                                                @if ($dailyQuizData->quiz_type ==  'truefalse')
                                                    <form id="smallquizform">
                                                        <div class="question">
                                                            <h5>Q: {{ $dailyQuizData->question }}</h5>
                                                            <label><input type="radio" name="q1" value="{{ $dailyQuizData->option1 }}"> {{ $dailyQuizData->option1 }}</label><br>
                                                            <label><input type="radio" name="q1" value="{{ $dailyQuizData->option2 }}"> {{ $dailyQuizData->option2 }}</label><br>
                                                        </div>
                                                        <!-- Add more questions here -->
                                                        <button type="button" class="btn btn-block btn-danger" id="smallquizsubmit">Submit</button>
                                                    </form>  
                                                    
                                                    <div id="result-container" style="display: none;">
                                                        <h2>Result</h2>
                                                        <p id="result"></p>
                                                        <p id="explanation"></p>
                                                    </div>
                                                @endif
                                               
                                                @if ($dailyQuizData->quiz_type ==  'statement')
                                                     <div class="alert alert-primary">{{ $dailyQuizData->question }}</div>
                                                    
                                                @endif
                                            
                                            @endif
                                        </div>
                                        
                                       
                                    
                                    </div>
                                    <div class="col-md-12 col">
                                        
                                        <button type="button" class="btn btn-warning float-right mt-2" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        {{-- Intro User  modal --}}
        
        {{-- Feedback Form  modal --}}
        <div class="modal fade" id="feedback_form_modal" aria-hidden="true" role="dialog">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action={{ route('user.submituserfeedback') }} method="post">
                        @csrf
                        <div class="modal-body">
                            <h6>Q1. On a scale of 1 to 5, how beneficial was the e-learning portal in enhancing
                                your knowledge and skills?</h6>
                                <input type="hidden" name="Feedback[q1][quest]" value="Question1">
                                <div class="funkyradio">
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q1][feedQ1]" value="Not at all beneficial"  id="radio1" />
                                    <label for="radio1">Not at all beneficial</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q1][feedQ1]" value="Somewhat beneficial" id="radio2" />
                                    <label for="radio2">Somewhat beneficial</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q1][feedQ1]" value="Moderately beneficial" id="radio3" />
                                    <label for="radio3">Moderately beneficial</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q1][feedQ1]" value="Very beneficial" id="radio4" />
                                    <label for="radio4">Very beneficial</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q1][feedQ1]" value="Completely beneficial" id="radio5" />
                                    <label for="radio5">Completely beneficial</label>
                                </div>
                            </div>

                            <hr>
                        
                            <h6>Q2. How would you rate the quality of the new information in learning modules
                                provided on the e-learning platform?</h6>
                                <input type="hidden" name="Feedback[q2][quest]" value="Question2">

                                <div class="funkyradio">
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q2][feedQ2]" value="Very poor" id="radio6" />
                                    <label for="radio6">Very poor</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q2][feedQ2]" value="Poor" id="radio7" />
                                    <label for="radio7">Poor</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q2][feedQ2]" value="Fair" id="radio8" />
                                    <label for="radio8">Fair</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q2][feedQ2]" value="Good" id="radio9" />
                                    <label for="radio9">Good</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q2][feedQ2]" value="Excellent" id="radio10" />
                                    <label for="radio10">Excellent</label>
                                </div>
                            </div>

                            <hr>


                            <h6>Q3. How would you rate the relevance of the content provided on the e-
                                learning platform?</h6>
                                <input type="hidden" name="Feedback[q3][quest]" value="Question3">

                                <div class="funkyradio">
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q3][feedQ3]" value="Insufficient" id="radio11" />
                                    <label for="radio11">Insufficient</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q3][feedQ3]" value="Somewhat insufficient" id="radio12" />
                                    <label for="radio12">Somewhat insufficient</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q3][feedQ3]" value="Moderately sufficient" id="radio13" />
                                    <label for="radio13">Moderately sufficient</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q3][feedQ3]" value="Somewhat sufficient" id="radio14" />
                                    <label for="radio14">Somewhat sufficient</label>
                                </div>
                                <div class="funkyradio-primary">
                                    <input type="radio" name="Feedback[q3][feedQ3]" value="Sufficient" id="radio15" />
                                    <label for="radio15">Sufficient</label>
                                </div>
                            </div>

                            <hr>
                            
                                <div class="form-group">
                                    <label for="input-one">Q4. Any other topics you would like to learn more about?</label>
                                    <input type="hidden" name="Feedback[q4][quest]" value="Question4">

                                    <input type="text" class="form-control" name="Feedback[q4][feedQ4]" id="input-one" placeholder="">
                                    <small class="text-danger">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>

                                </div>
                                
                                <hr>

                                <div class="form-group">
                                    <h6>Q5. Would you to recommend this e-learning platform to other counsellor
                                        based on your experience ?</h6>
                                        <input type="hidden" name="Feedback[q5][quest]" value="Question5">

                                        <div class="funkyradio">
                                        <div class="funkyradio-primary">
                                            <input type="radio" name="Feedback[q5][feedQ5]" value="Yes" id="radio16" />
                                            <label for="radio16">Yes</label>
                                        </div>
                                        <div class="funkyradio-primary">
                                            <input type="radio" name="Feedback[q5][feedQ5]" value="No" id="radio17" />
                                            <label for="radio17">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div id="counselorInfo" style="display: none;">
                                    <div class="form-group">
                                        <input type="hidden" name="Feedback[q6][quest]" value="Name Of Counsellor">
                                        <label for="counselorName">Name of the Counselor</label>
                                        <input type="text" class="form-control" name="Feedback[q6][feedQ6]"  id="counselorName">
                                        <small class="text-danger">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>

                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="Feedback[q7][quest]" value="Counsellor Phone Number">
                                        <label for="phoneNumber">Phone Number</label>
                                        <input type="text" class="form-control" name="Feedback[q7][feedQ7]" id="phoneNumber">
                                        <small class="text-danger">Only numbers are allowed.</small>

                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="Feedback[q8][quest]" value="Counsellor Email ID">
                                        <label for="email">Email ID</label>
                                        <input type="email" class="form-control" name="Feedback[q8][feedQ8]" id="email">
                                    </div>
                                    <div class="form-group">
                                        <label for="doctorName">Doctor Name</label>
                                        <input type="hidden" name="Feedback[q9][quest]" value="Doctor Name">
                                        <input type="text" class="form-control" name="Feedback[q9][feedQ9]" id="doctorName">
                                        <small class="text-danger">Only alphabets, numbers, spaces, and special characters: @!#.,-+ are allowed.</small>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Feedback Form  modal --}}
        
        {{-- Appointment Form  modal --}}
        <div class="modal fade" id="appointment_form_modal" aria-hidden="true" role="dialog">
            <div class="modal-dialog  modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        @php
                            // Run SQL query to fetch resource data from the 'resources' table
                            $appointmentData = DB::select("SELECT * FROM appointments WHERE project_manager_id = ?", [$registered_course_detail["by_prj_manager_id"]]);
            
                        @endphp
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Select time slot for doctor interaction</h4>
                            </div>
                            <div class="card-body">
                                @if (!empty($appointmentData) && isset($appointmentData[0]))
                                <ul class="nav nav-tabs nav-tabs-solid nav-justified">
                                    @if ($appointmentData[0]->appointment_section_1_booking == 'yes')
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#solid-justified-tab1" data-toggle="tab">
                                                {{ \Carbon\Carbon::parse($appointmentData[0]->appointment_section_1_date)->format('d-M-Y') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if ($appointmentData[0]->appointment_section_2_booking == 'yes')
                                        <li class="nav-item">
                                            <a class="nav-link" href="#solid-justified-tab2" data-toggle="tab">
                                                {{ \Carbon\Carbon::parse($appointmentData[0]->appointment_section_2_date)->format('d-M-Y') }}
                                            </a>
                                        </li>
                                    @endif
                                    @if ($appointmentData[0]->appointment_section_3_booking == 'yes')
                                        <li class="nav-item">
                                            <a class="nav-link" href="#solid-justified-tab3" data-toggle="tab">
                                                {{ \Carbon\Carbon::parse($appointmentData[0]->appointment_section_3_date)->format('d-M-Y') }}
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane show active" id="solid-justified-tab1">
                                        @if ($appointmentData[0]->appointment_section_1_booking == 'yes')
                                            <form action="{{ route('user.registerappointment') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="course_registrations_id" value="{{ $registered_course_detail["id"] }}">
                                                <input type="hidden" name="appointment_date" value="{{ $appointmentData[0]->appointment_section_1_date }}">
                                                <div class="funkyradio">
                                                    @if ($appointmentData[0]->section_1_time_slot_1)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_1_time_slot_1}}" id="timeslot1" required/>
                                                            <label for="timeslot1">{{$appointmentData[0]->section_1_time_slot_1}}</label>
                                                        </div>
                                                    @endif
                                                    @if ($appointmentData[0]->section_1_time_slot_2)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_1_time_slot_2}}" id="timeslot2" required/>
                                                            <label for="timeslot2">{{$appointmentData[0]->section_1_time_slot_2}}</label>
                                                        </div>
                                                    @endif
                                                    @if ($appointmentData[0]->section_1_time_slot_3)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_1_time_slot_3}}" id="timeslot3" required/>
                                                            <label for="timeslot3">{{$appointmentData[0]->section_1_time_slot_3}}</label>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="tab-pane" id="solid-justified-tab2">
                                        @if ($appointmentData[0]->appointment_section_2_booking == 'yes')
                                            <form action="{{ route('user.registerappointment') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="course_registrations_id" value="{{ $registered_course_detail["id"] }}">
                                                <input type="hidden" name="appointment_date" value="{{ $appointmentData[0]->appointment_section_2_date }}">
                                                <div class="funkyradio">
                                                    @if ($appointmentData[0]->section_2_time_slot_1)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_2_time_slot_1}}" id="time_section_2_slot1" required/>
                                                            <label for="time_section_2_slot1">{{$appointmentData[0]->section_2_time_slot_1}}</label>
                                                        </div>
                                                    @endif
                                                    @if ($appointmentData[0]->section_2_time_slot_2)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_2_time_slot_2}}" id="time_section_2_slot2" required/>
                                                            <label for="time_section_2_slot2">{{$appointmentData[0]->section_2_time_slot_2}}</label>
                                                        </div>
                                                    @endif
                                                    @if ($appointmentData[0]->section_2_time_slot_3)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_2_time_slot_3}}" id="time_section_2_slot3" required/>
                                                            <label for="time_section_2_slot3">{{$appointmentData[0]->section_2_time_slot_3}}</label>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="tab-pane" id="solid-justified-tab3">
                                        @if ($appointmentData[0]->appointment_section_3_booking == 'yes')
                                            <form action="{{ route('user.registerappointment') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="course_registrations_id" value="{{ $registered_course_detail["id"] }}">
                                                <input type="hidden" name="appointment_date" value="{{ $appointmentData[0]->appointment_section_3_date }}">
                                                <div class="funkyradio">
                                                    @if ($appointmentData[0]->section_3_time_slot_1)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_3_time_slot_1}}" id="time_section_3_slot1" required/>
                                                            <label for="time_section_3_slot1">{{$appointmentData[0]->section_3_time_slot_1}}</label>
                                                        </div>
                                                    @endif
                                                    @if ($appointmentData[0]->section_3_time_slot_2)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_3_time_slot_2}}" id="time_section_3_slot2" required/>
                                                            <label for="time_section_3_slot2">{{$appointmentData[0]->section_3_time_slot_2}}</label>
                                                        </div>
                                                    @endif
                                                    @if ($appointmentData[0]->section_3_time_slot_3)
                                                        <div class="funkyradio-primary">
                                                            <input type="radio" name="time_slot" value="{{$appointmentData[0]->section_3_time_slot_3}}" id="time_section_3_slot2" required/>
                                                            <label for="time_section_3_slot3">{{$appointmentData[0]->section_3_time_slot_3}}</label>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                @else
                                    <p>No appointment data available.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Appointment Form  modal --}}

<!-- /Page Wrapper -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function(){
    
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    
    $(".next").click(function(){
        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        //Add Class Active
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
    
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    $(".previous").click(function(){
        
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show();
    
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;
    
                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            }, 
            duration: 600
        });
    });
    
    $('.radio-group .radio').click(function(){
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });
    
    $(".submit").click(function(){
        return false;
    });

    @auth
    
            $('#user_intro_modal').modal('show');
    @if(Auth::user()->user_intro == '0' && !isset($_COOKIE['userIntroShown']))
            $('#user_intro_modal').modal('show');
            <?php
                // Set the cookie to expire in 24 hours
                setcookie('userIntroShown', '1', time() + (24 * 60 * 60), '/');
            ?>
        @endif
    @endauth
        
});
</script>

<script>
  $(document).ready(function(){

    // Function to show a specific section and hide all others
    function showSection(sectionNumber) {
        // Hide all sections
        $("fieldset").css({
            'opacity': 0,
            'position': 'relative',
            'display': 'none'
        });
        // Show the selected section
        $(".section-" + sectionNumber).css({
            'opacity': 1,
            'position': 'relative',
            'display': 'block'
        });
    }

    // Click event handler for each button
    $(".section-button").click(function(){
        var sectionNumber = $(this).data("section"); // Get the section number from data-section attribute
        showSection(sectionNumber); // Show the corresponding section
    });

    // Initially show the first section
    // showSection(1);

});
</script>



@if(session('Module_Completed') == 'Success' && $registered_course_detail["feedback"] == null)
<script>
        $(document).ready(function(){
            let questionDataString = '<div class="container">';
            @foreach (session('questionData') as $question)
                questionDataString += '<div class="card">';
                questionDataString += '<div class="card-header"><strong> {{ $question['question'] }} </strong></div>';
                questionDataString += '<div class="card-body">';
                questionDataString += '<p class="alert ';
                questionDataString += ("{{ $question['user_selected_option'] }}" == "{{ $question['correct_option'] }}") ? 'alert-success' : 'alert-danger';
                questionDataString += '"> <small>You selected option: {{ $question['user_selected_option_name'] }} | Correct answer:</strong> {{ $question['correct_option_name'] }} </small> ';
                // Add Font Awesome icon under the alert paragraph
                questionDataString += '<i class="ml-1 ';
                questionDataString += ("{{ $question['user_selected_option'] }}" == "{{ $question['correct_option'] }}") ? 'text-success  fe fe-check-circle' : 'text-danger fe fe-frowing';
                questionDataString += '"></i>';
                questionDataString += '</p>';
                questionDataString += '<p class="alert alert-primary"><small><strong>Explanation </strong>: {{ $question['correct_answer_explanation'] }} </small></p>';
                questionDataString += '</div>'; // Closing card-body
                questionDataString += '</div>'; // Closing card
            @endforeach
            questionDataString += '</div>'; // Closing container

            Swal.fire({
                title: 'Good Job !!!!',
                html: questionDataString,
                icon: '{{ session('moduleAlert') }}'
            });
        });
    </script>
@endif


@if(session('Module_Completed') == 'Error')
    <script>
        $(document).ready(function(){
            let questionDataString = '<div class="container">';
            @foreach (session('questionData') as $question)
                questionDataString += '<div class="card">';
                questionDataString += '<div class="card-header"><strong> {{ $question['question'] }} </strong></div>';
                questionDataString += '<div class="card-body">';
                questionDataString += '<p class="alert ';
                questionDataString += ("{{ $question['user_selected_option'] }}" == "{{ $question['correct_option'] }}") ? 'alert-success' : 'alert-danger';
                questionDataString += '"> <small>User Selected Option: {{ $question['user_selected_option_name'] }} | Correct Option:</strong> {{ $question['correct_option_name'] }} </small> ';
                // Add Font Awesome icon under the alert paragraph
                questionDataString += '<i class="ml-1 ';
                questionDataString += ("{{ $question['user_selected_option'] }}" == "{{ $question['correct_option'] }}") ? 'text-success  fe fe-check-circle' : 'text-danger fe fe-frowing';
                questionDataString += '"></i>';
                questionDataString += '</p>';
                questionDataString += '<p class="alert alert-primary"><small><strong>Explanation </strong>: {{ $question['correct_answer_explanation'] }} </small></p>';
                questionDataString += '</div>'; // Closing card-body
                questionDataString += '</div>'; // Closing card
            @endforeach
            questionDataString += '</div>'; // Closing container

            Swal.fire({
                title: 'Ohhh No !!!!',
                html: questionDataString,
                icon: '{{ session('moduleAlert') }}'
            });
        });
    </script>
@endif


@if ($moduleCompletedCount == $TotalmoduleCount)
    <script>
        $(document).ready(function(){
            
            @if ( $registered_course_detail["feedback"] != null && $registered_course_detail["appointment_booked_status"] == 'no')
                $('#appointment_form_modal').modal('show');
            @endif

            
            @if ($registered_course_detail["feedback"] == null)
                $('#feedback_form_modal').modal('show');
            @endif

            $('input[name="Feedback[q5][feedQ5]"]').change(function(){
                if($(this).val() == 'Yes'){
                    $('#counselorInfo').show();
                } else {
                    $('#counselorInfo').hide();
                }
            });
        
        });
    </script>
@endif

<script>
   $(document).ready(function() {
        $('#smallquizsubmit').click(function() {
            // Check if any option is selected
            if (!$('#smallquizform input[name="q1"]:checked').val()) {
                alert('Please select an option before submitting.');
                return; // Prevent further execution
            }

            @php
                // Run SQL query to fetch resource data from the 'resources' table
                $dailyQuizData = \App\Models\DailyQuiz::find(1);
            @endphp

            @if ($dailyQuizData)
                // Get the selected answer and correct answer from the server
                var selectedAnswer = $('#smallquizform input[name="q1"]:checked').val();
                var correctAnswer = '{{ $dailyQuizData->correct_option }}';
                var explanation = '{{ $dailyQuizData->explanation }}';

                
                if (selectedAnswer === correctAnswer) {
                    $('#result').html('<div class="alert alert-success">Correct!</div>');
                } else {
                    $('#result').html('<div class="alert alert-danger">Incorrect!</div>');
                }
                
                $('#explanation').html('<div class="alert alert-primary"><strong>Explanation</strong><br>' + explanation + '</div>');
                $('#result-container').show();

                // Hide the submit button
                $('#smallquizsubmit').hide();
            
            @endif

            
        });
    });
</script>



@endsection
