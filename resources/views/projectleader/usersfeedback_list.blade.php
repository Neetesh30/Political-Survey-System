@extends('layouts.projectleader.master')
@section('title','Manage User List')

@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
            
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-md-7">
                        <h3 class="page-title">Feedback List</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('projectleader.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">User List </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Users Feedback List</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="datatable table table-stripped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone No</th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    How beneficial was the e-learning portal in enhancing your knowledge and skills?
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    How would you rate the quality of the new information in learning modules provided on the e-learning platform?
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    How would you rate the relevance of the content provided on the e-learning platform?
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    Any other topics you would like to learn more about?
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    Would you to recommend this e-learning platform to other counsellor based on your experience ?
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    Name of the Counselor
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    Phone Number
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    Email ID
                                                </div>
                                            </th>
                                            <th>
                                                <div style='width: 200px; overflow-x: auto;'>
                                                    Doctor Name
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($feedback_detail as $item)
                                            @php
                                                $userData = DB::select("SELECT name, email, phone FROM users WHERE id = ?", [$item['user_id']]);
                                            @endphp
                                            <tr>
                                                @if (!empty($userData))
                                                    <td>{{ $userData[0]->name }}</td>
                                                    <td>{{ $userData[0]->email }}</td>
                                                    <td>{{ $userData[0]->phone }}</td>

                                                    @php
                                                        // Assuming $item->feedback contains the JSON string
                                                        $feedbackArray = json_decode($item->feedback, true);
                                                        // Check if decoding was successful
                                                        if ($feedbackArray) {
                                                            // Loop through each feedback item
                                                            $answer_count = 0;
                                                            foreach ($feedbackArray as $feedback) {
                                                                $answer_count ++;
                                                                // Access each question and answer
                                                                $answer = isset($feedback["answer_q$answer_count"]) ? $feedback["answer_q$answer_count"] : "No answer provided";

                                                                // Display the question and answer
                                                                echo "<td>
                                                                    <div style='width: 200px; overflow-x: auto;'>$answer</div>
                                                                    </td>";
                                                            }
                                                        } else {
                                                            // Handle JSON decoding error
                                                            echo "<td>Error no record found</td>";
                                                        }
                                                    @endphp
                                                    @else
                                                        <td colspan="2">No registration found</td>
                                                    @endif
                                                </tr>
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

    @endsection