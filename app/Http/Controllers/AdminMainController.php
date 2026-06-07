<?php

namespace App\Http\Controllers;

use App\Models\Courseregistrations;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Resources;
use App\Models\Quizs;
use App\Models\Courses;
use App\Models\Quizregistrations;
use App\Models\DoctorRegistrations;
use App\Models\Appointments;
use App\Models\Registrations;
use App\Models\DailyQuiz;
use Illuminate\Support\Facades\DB;
use App\Mail\ZoomDetailsUpdated;
use Illuminate\Support\Facades\Mail;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log; // Make sure this is included at the top



use Validator;

use SproutVideo;
use Exception;

SproutVideo::$api_key = '2f0e312d22e50b4e6a6c24714a3fd453';
class AdminMainController extends Controller
{
    
    public function counsellor_register($id){
        if($id){
            $projmngr_detail = User::where('uniq_id', $id)->where('status', 'active')->first();
                if ($projmngr_detail) {
                    return view('guest_counsellor_register', ['projmngr_detail' => $projmngr_detail]);
                } else {
                    return view('guest_counsellor_register', ['projmngr_detail' => null])->with('danger', 'Sorry, the user is not active or not available. Please try again later.');
                }
        }

    }
    
    
    public function store_counsellor(Request $request){
        $request->validate([
            'id' => "required|exists:users,uniq_id",
            'name' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'digits:10', 'unique:users,phone', 'regex:/^[0-9]+$/'],
        ], [
            'name.regex' => 'The :attribute is invalid. Only letters and spaces are allowed.',
        ]);

      
            try {

                $projmngr_detail = User::where('uniq_id', $request->id)->where('status', 'active')->first();

                // Create a new counsellor
                $add_counsellor = new User;
                $add_counsellor->name = $request->name;
                $add_counsellor->email = strtolower($request->email);
                $add_counsellor->phone = $request->phone;
                $add_counsellor->by_prj_manager_id = $projmngr_detail->id;
                $add_counsellor->address = 'dummy address';
                $add_counsellor->role = 5; // Assuming '5' represents the counsellor role
                $add_counsellor->status = 'active';
                $add_counsellor->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
                $add_counsellor->save();

                if($add_counsellor){
                    
                    $course_details = Courses::where('createdby_user_id', $projmngr_detail->id)->latest()->first();
                    $add_user_quizregistrations = new Courseregistrations;
                    $add_user_quizregistrations->user_id = $add_counsellor->id;
                    $course_id = $course_details ? $course_details->id : 0; // Assign course ID if found
                    $add_user_quizregistrations->by_prj_manager_id = $projmngr_detail->id;

                    if($course_details){
                        $add_user_quizregistrations->course_id = $course_details->id;
                         // Loop through module details and assign them dynamically
                        for ($i = 1; $i <= 15; $i++) {
                            $module_field = 'module_' . $i;
                            $quiz_field = 'module_' . $i . '_quiz';
                            $completion_field = 'module_' . $i . '_completion_percentage';
                            if ($course_details->$module_field != null) {
                                $add_user_quizregistrations->$module_field = $course_details->$module_field;
                                $add_user_quizregistrations->$quiz_field = $course_details->$quiz_field;
                                $add_user_quizregistrations->$completion_field = $course_details->$completion_field;
                            }
                        }
                    }else{
                        $add_user_quizregistrations->course_id = 0;
                         // Loop through module details and assign them dynamically
                        for ($i = 1; $i <= 6; $i++) {
                            $module_field = 'module_' . $i;
                            $quiz_field = 'module_' . $i . '_quiz';
                            $completion_field = 'module_' . $i . '_completion_percentage';
                            $add_user_quizregistrations->$module_field = 1 ;
                            $quiz_data = [
                                "mcqs" => [
                                    "1" => [
                                        "question" => "Course not created , this is a dummy question ",
                                        "user_selected_option" => "null",
                                        "options" => ["aa", "bb", "cc", "dd"],
                                        "correct_answer" => "2",
                                        "correct_answer_explanation" => "some answer"
                                    ]
                                ]
                            ];
                            $add_user_quizregistrations->$quiz_field = json_encode($quiz_data);
                            $add_user_quizregistrations->$completion_field = 50;
                        }

                    }
                    $add_user_quizregistrations->save();


                    return redirect()->route('login')->with('success', 'Counsellor added successfully');
                } 
                else{
                    return redirect()->back()->with('danger','Sorry counsellor not created , try again later');
                } 

            } catch (\Exception $e) {
                // Log the error
                \Log::error('Error adding counsellor: '.$e->getMessage());

                return redirect()->back()->with('danger', 'Sorry, the counsellor was not created, error code: 3214. Please try again later.');
            }
    }
    
    public function importusers(Request $request)
{
    // Validate the uploaded CSV file
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $path = $request->file('csv_file')->getRealPath();
    $rows = array_map('str_getcsv', file($path));

    // Skip the header row if it exists
    $header = array_shift($rows);

    // Check if the number of rows exceeds the allowed limit
    $maxUsers = 50;
    if (count($rows) > $maxUsers) {
        return redirect()->back()->with('danger', 'Error: The CSV file contains more than the allowed limit of ' . $maxUsers . ' users.');
    }

    try {
        $users = [];
        $existingUsers = [];
        foreach ($rows as $row) {
            // Validate individual row data
            if (!isset($row[0], $row[1], $row[2])) {
                throw new Exception('Missing required data in CSV row.');
            }

            $name = $row[0];
            $email = strtolower($row[1]);
            $phone = $row[2];

            // Validate name
            if (!preg_match('/^[a-zA-Z ]*$/', $name)) {
                throw new Exception('Invalid name in CSV row.');
            }

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Invalid email in CSV row.');
            }

            // Validate phone number (assuming 10 digits)
            if (!preg_match('/^\d{10}$/', $phone)) {
                throw new Exception('Invalid phone number in CSV row.');
            }

            // Check if email or phone already exists
            $existingUser = User::where('email', $email)->orWhere('phone', $phone)->first();
            if ($existingUser) {
                $existingUsers[] = [
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                ];
                continue;
            }

            // Collect user data
            $users[] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'by_prj_manager_id' => auth()->user()->id, // Assuming the current user is the project manager
                'address' => 'dummy address',
                'role' => 5, // Assuming '5' represents the counsellor role
                'status' => 'active',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // Use a secure way to generate passwords
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert the collected users into the database
        if (!empty($users)) {
            User::insert($users);
        }

        // Fetch the inserted users from the database
        $insertedUsers = User::where('by_prj_manager_id', auth()->user()->id)
                             ->whereIn('email', array_column($users, 'email'))
                             ->get();

        foreach ($insertedUsers as $user) {
            $course_details = Courses::where('createdby_user_id', auth()->user()->id)->latest()->first();
            $add_user_quizregistrations = new Courseregistrations;
            $add_user_quizregistrations->user_id = $user->id;
            $add_user_quizregistrations->course_id = $course_details ? $course_details->id : 0;
            $add_user_quizregistrations->by_prj_manager_id = auth()->user()->id;

            // Loop through module details and assign them dynamically
            for ($i = 1; $i <= 6; $i++) {
                $module_field = 'module_' . $i;
                $quiz_field = 'module_' . $i . '_quiz';
                $completion_field = 'module_' . $i . '_completion_percentage';

                if ($course_details) {
                    if ($course_details->$module_field != null) {
                        $add_user_quizregistrations->$module_field = $course_details->$module_field;
                        $add_user_quizregistrations->$quiz_field = $course_details->$quiz_field;
                        $add_user_quizregistrations->$completion_field = $course_details->$completion_field;
                    }
                } else {
                    $add_user_quizregistrations->$module_field = 1;
                    $quiz_data = [
                        "mcqs" => [
                            "1" => [
                                "question" => "Course not created by Admin Manager, this is a dummy question",
                                "user_selected_option" => "null",
                                "options" => ["aa", "bb", "cc", "dd"],
                                "correct_answer" => "2",
                                "correct_answer_explanation" => "some answer"
                            ]
                        ]
                    ];
                    $add_user_quizregistrations->$quiz_field = json_encode($quiz_data);
                    $add_user_quizregistrations->$completion_field = 50;
                }
            }

            $add_user_quizregistrations->save();
        }

        $message = 'Users imported successfully.';
        if (!empty($existingUsers)) {
            $message .= ' The following users already exist and were not added: ';
            foreach ($existingUsers as $existingUser) {
                $message .= $existingUser['name'] . ' (' . $existingUser['email'] . '), ';
            }
            $message = rtrim($message, ', ');
        }

        return redirect()->back()->with('success', $message);

    } catch (\Exception $e) {
        // Log the error
        \Log::error('Error importing users: '.$e->getMessage());

        return redirect()->back()->with('danger', 'Error importing users. Please check the CSV file and try again.');
    }
}


    public function admin_show_dashboard_data(){

        $total_new_doctor_count = DoctorRegistrations::where('status','new')->count();
        $total_approved_doctor_count = DoctorRegistrations::where('status','approved')->count();
        $total_rejected_doctor_count = DoctorRegistrations::where('status','rejected')->count();
        $total_verification_doctor_count = DoctorRegistrations::where('status','verification')->count();
        $total_new_doctor_list = DoctorRegistrations::where('status','new')->get();
        $total_verification_doctor_list = DoctorRegistrations::where('status','verification')->get();
        $total_approved_doctor_list = DoctorRegistrations::where('status','approved')->get();
        $total_rejected_doctor_list = DoctorRegistrations::where('status','rejected')->get();
        return view('admin.home',[
            'total_new_doctor_count' => $total_new_doctor_count,
            'total_approved_doctor_count' => $total_approved_doctor_count,
            'total_rejected_doctor_count' => $total_rejected_doctor_count,
            'total_verification_doctor_count' => $total_verification_doctor_count,
            'total_new_doctor_list' => $total_new_doctor_list,
            'total_verification_doctor_list' => $total_verification_doctor_list,
            'total_approved_doctor_list' => $total_approved_doctor_list,
            'total_rejected_doctor_list' => $total_rejected_doctor_list,
        ]);
    }


    public function createprjmanager(Request $request){

        $request->validate([
            'name' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric','digits_between:10,10', 'unique:users,phone','regex:/^[0-9]+$/',],
        ], [
            'name.regex' => 'The :attribute is invalid. Only letters and spaces are allowed.',
        ]);
        
        $add_prjmangr = new User;
        
        $add_prjmangr->name = $request->name;
        $add_prjmangr->email = $request->email;
        $add_prjmangr->phone = $request->phone;
        $add_prjmangr->by_prj_manager_id = auth()->user()->id;
        $add_prjmangr->status = 'active';
        $add_prjmangr->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        
        $add_prjmangr -> save();

        if ($add_prjmangr) {
            // Generate QR code
            $uniq_code = Str::random(8); // Generates a random 8-character string
            $qrCodeData = url('/counselloregister/'.$uniq_code);
            $qrFileName = 'qr_' . $add_prjmangr->id . '_' . time() . '.png';
            $qrFilePath = 'public/qr/' . $qrFileName;

            // Use the endroid/qr-code library to generate the QR code
            $qrCode = QrCode::create($qrCodeData)
                ->setSize(200)
                ->setMargin(10);
                
            $writer = new PngWriter();
            $qrCodeImage = $writer->write($qrCode)->getString();

            // Save the QR code to the specified path
            Storage::put($qrFilePath, $qrCodeImage);

            // Optionally, save the QR code path to the database
            $add_prjmangr->uniq_id = $uniq_code;
            $add_prjmangr->qrcode_path = $qrFileName;
            $add_prjmangr->save();

            return redirect()->route('admin.prjmngrlist')->with('success', 'Project Manager Added Successfully');
        } 
        else{
            return redirect()->route('admin.prjmngrlist')->with('danger','Sorry Project Manager not cretaed , try again later');
        }

    }

    
    public function new_doctor_registration(Request $request){

        $request->validate([
            'username' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'useremail' => ['required', 'email', 'unique:doctor_registrations,email'],
            'userphone' => ['required', 'numeric','digits_between:10,10', 'unique:users,phone','regex:/^[0-9]+$/',],
            'doctor_name' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'doctor_email' => ['required', 'email', 'unique:doctor_registrations,doctor_email'],
            'doctor_address' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/'],
            'doctor_city' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/'],
            'doctor_state' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/'],
            'doctor_pincode' => ['required', 'string', 'regex:/^[0-9]+$/'],
        ]);
        
        $add_new_doct_reg = new DoctorRegistrations;
        
        $add_new_doct_reg->name = $request->username;
        $add_new_doct_reg->email = $request->useremail;
        $add_new_doct_reg->phone = $request->userphone;
        $add_new_doct_reg->doctor_name = $request->doctor_name;
        $add_new_doct_reg->doctor_email = $request->doctor_email;
        $add_new_doct_reg->doctor_address = $request->doctor_address;
        $add_new_doct_reg->doctor_city = $request->doctor_city;
        $add_new_doct_reg->doctor_state = $request->doctor_state;
        $add_new_doct_reg->doctor_pincode = $request->doctor_pincode;
        
        $add_new_doct_reg -> save();

        if($add_new_doct_reg){
            return redirect()->back()->with('success','Doctor details registered successfully');
        }else{
            return redirect()->back()->with('danger','Sorry Doctor details not cretaed , try again later');
        }

    }

    public function change_new_doctor_reg_status(Request $request){
        
        $request -> validate([
            'id' => "required|exists:doctor_registrations,id",
        ]);

        $update_new_doctor_status =  DoctorRegistrations::findOrFail($request->id);
        
        $update_new_doctor_status->status =  'verification';
        
        $update_new_doctor_status -> save();
        
        if($update_new_doctor_status){
            return redirect()->route('admin.home')->with('success', "<b>$update_new_doctor_status->name</b> updated successfully");
        }else{
            return  redirect()->route('admin.prjmngrlist')->with('fail',"<b>$update_new_doctor_status->name</b> update failed, try again later");
        }

    
    }
    
    public function change_new_doctor_approve_status(Request $request){
        
        $request -> validate([
            'id' => "required|exists:doctor_registrations,id",
        ]);

        $update_approve_doctor_status =  DoctorRegistrations::findOrFail($request->id);
        
        $update_approve_doctor_status->status =  'approved';
        
        $update_approve_doctor_status -> save();


        //dd($request);
       $add_approved_user_prjmangr = new User;
        
       $add_approved_user_prjmangr->name = $update_approve_doctor_status->doctor_name;
       $add_approved_user_prjmangr->email = $update_approve_doctor_status->doctor_email;
       $add_approved_user_prjmangr->phone = $update_approve_doctor_status->phone;
       $add_approved_user_prjmangr->status = 'active';
       $add_approved_user_prjmangr->by_prj_manager_id = 1;
       $add_approved_user_prjmangr->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
       
       $add_approved_user_prjmangr -> save();
        
        if($update_approve_doctor_status && $add_approved_user_prjmangr){
                $uniq_code = Str::random(8); // Generates a random 8-character string
                // Generate QR code
                $qrCodeData = url('/counselloregister/' . $uniq_code);
                $qrFileName = 'qr_' . $add_approved_user_prjmangr->id . '_' . time() . '.png';
                $qrFilePath = 'public/qr/' . $qrFileName;
    
                // Use the endroid/qr-code library to generate the QR code
                $qrCode = QrCode::create($qrCodeData)
                    ->setSize(200)
                    ->setMargin(10);
                    
                $writer = new PngWriter();
                $qrCodeImage = $writer->write($qrCode)->getString();
    
                // Save the QR code to the specified path
                Storage::put($qrFilePath, $qrCodeImage);
    
                // Optionally, save the QR code path to the database
                $add_approved_user_prjmangr->uniq_id = $uniq_code;
                $add_approved_user_prjmangr->qrcode_path = $qrFileName;
                $add_approved_user_prjmangr->save();
    
            return redirect()->route('admin.home')->with('success', "<b>$update_approve_doctor_status->name</b> updated successfully");
        }else{
            return  redirect()->route('admin.prjmngrlist')->with('fail',"<b>$update_approve_doctor_status->name</b> update failed, try again later");
        }

    
    }
    
    public function change_new_doctor_reject_status(Request $request){
        
        $request -> validate([
            'id' => ['required','exists:doctor_registrations,id'],
            'remarks' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/'],
        ]);

        $update_reject_doctor_status =  DoctorRegistrations::findOrFail($request->id);
        
        $update_reject_doctor_status->status =  'rejected';
        $update_reject_doctor_status->remarks =  $request->remarks;
        $update_reject_doctor_status -> save();
        
        if($update_reject_doctor_status){
            return redirect()->route('admin.home')->with('success', "<b>$update_reject_doctor_status->name</b> updated successfully");
        }else{
            return  redirect()->route('admin.prjmngrlist')->with('fail',"<b>$update_reject_doctor_status->name</b> update failed, try again later");
        }

    
    }


    public function getprjmngrlist(){

        $prjmngrdata = User::where('role', 2)->get();

        

        //dd($datas);

         return view('admin.projectmangrlist',['PrjmngrList' => $prjmngrdata]);
    }
   
    


    public function editprjmanager(Request $request){
        
        $request -> validate([
            'name' => "required|min:4|max:50|regex:/^[a-zA-Z ]*$/",
            'email' => "required|email",
            'phone' => ['required', 'numeric','digits_between:10,10', 'unique:users,phone','regex:/^[0-9]+$/',],
        ],[
            'name.regex' => $request->name." is invalid only letters and space is allowed.",
        ]);

        $update_prjmngr_id = $request->id;
        
        $update_prjmngr =  User::findOrFail($update_prjmngr_id);
        
        $update_prjmngr -> name =  $request->name;
        $update_prjmngr -> email =  $request->email;
        $update_prjmngr -> phone =  $request->phone;
        
        $update_prjmngr -> save();
        
        if($update_prjmngr){
            return redirect()->route('admin.prjmngrlist')->with('success', "Project Manager <b>$update_prjmngr->name</b> updated successfully");
        }else{
            return  redirect()->route('admin.prjmngrlist')->with('fail',"Project Manager <b>$update_prjmngr->name</b> update failed, try again later");
        }

    
    }

    public function deleteprjmanager(Request $request){
        $request -> validate([
            'id' => "required|exists:users,id",
        ],[
            'id.exists' => 'Sorry, Project Manager Id does not exist',
        ]);        

        $deleteprjmngr = User::find($request->id);

        $deleteprjmngr->delete();
    
        if($deleteprjmngr){
            return  redirect()->route('admin.prjmngrlist')->with('success',"Project Manager <b>$deleteprjmngr->name</b> is removed successfully");
        }else{
            return  redirect()->route('admin.prjmngrlist')->with('fail',"Project Manager <b>$deleteprjmngr->name</b> is not removed , try again later");
        }

    }

    public function daily_quiz(){

        $dailyquizdata = DailyQuiz::where('id', 1)->get();
        //  return view('admin.daily-quiz');
         return view('admin.daily-quiz',['dailyquizdata' => $dailyquizdata]);
    }


    public function store_daily_quiz(Request $request){
        $request->validate([
            'question' => 'required',
            // Validation rule for time slots
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'correct_option' => 'required',
            'explanation' => 'required',
        ]);

        // Create a new appointment instance
        $daily_quiz = new DailyQuiz();
        $daily_quiz->day = 1;
        $daily_quiz->question = $request->input('question');
        $daily_quiz->option1 = $request->input('option1');
        $daily_quiz->option2 = $request->input('option2');
        $daily_quiz->option3 = $request->input('option3');
        $daily_quiz->option4 = $request->input('option4');
        $daily_quiz->correct_option = $request->input('correct_option');
        $daily_quiz->explanation = $request->input('explanation');

        // Save the appointment
        $daily_quiz->save();

        
        if($daily_quiz){
            return redirect()->back()->with('success', "Daily quiz created successfully");
        }else{
            return  redirect()->back()->with('fail',"Sorry your daily quiz was not created, try again later");
        }

    
    }


    public function update_store_daily_quiz(Request $request, $id){
        $request->validate([
            'quiz_type' => 'required',
            'correct_option' => 'nullable',
            'question' => 'required',
            // Validation rule for time slots
            'option1' => 'nullable',
            'option2' => 'nullable',
            'option3' => 'nullable',
            'option4' => 'nullable',
            'explanation' => 'nullable',
        ]);

    
        $update_daily_quiz = DailyQuiz::findOrFail($id);
        $update_daily_quiz->quiz_type = $request->input('quiz_type');
        $update_daily_quiz->question = $request->input('question');
        $update_daily_quiz->option1 = $request->input('option1');
        $update_daily_quiz->option2 = $request->input('option2');
        $update_daily_quiz->option3 = $request->input('option3');
        $update_daily_quiz->option4 = $request->input('option4');
        $update_daily_quiz->correct_option = $request->input('correct_option');
        $update_daily_quiz->explanation = $request->input('explanation');
    
        // Save the appointment
        $update_daily_quiz->save();
    
        if ($update_daily_quiz) {
            return redirect()->back()->with('success', "Daily quiz updated successfully");
        } else {
            return redirect()->back()->with('fail', "Sorry, daily quiz could not be updated");
        }
    }


    // Project Manger Section

     public function project_mngr_show_dashboard_data(){

        $total_users_count = User::where('role','5')->where('by_prj_manager_id',auth()->user()->id)->count();
        $total_resources_count = Resources::where('resource_status','active')->where('createdby_user_id',auth()->user()->id)->count();
        $total_users_completed_course_count = Courseregistrations::where('course_status','completed')->where('by_prj_manager_id',auth()->user()->id)->count();
        $total_users_list = User::where('role','5')->where('by_prj_manager_id',auth()->user()->id)->get();
        return view('projectleader.home',[
            'total_users_count' => $total_users_count,
            'total_resources_count' => $total_resources_count,
            'total_users_completed_course_count' => $total_users_completed_course_count,
            'total_users_list' => $total_users_list,
        ]);
    }
    
    
    



    public function getmanageuserslist(){

        $mnguserdata = User::whereNotIn('role', [1, 2])->get();

         return view('projectleader.mangeuserslist',['mnguserdatalist' => $mnguserdata]);
    }


    public function manageuserstatus(Request $request){
        $request -> validate([
            'id' => "required|numeric",
        ]);

        $update_user_id = $request->id;
        
        $update_status =  User::findOrFail($update_user_id);
        $update_status->status = ($update_status->status == 'active') ? 'inactive' : 'active';
        $update_status -> save();
        
        if($update_status){
            return redirect()->back()->with('success', "User <b>$update_status->name</b> status updated successfully");
        }else{
            return  redirect()->back()->with('fail',"User <b>$update_status->name</b> status update failed, try again later");
        }
    
    }

    public function createuser(Request $request){
        $request->validate([
            'name' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric','digits_between:10,10', 'unique:users,phone','regex:/^[0-9]+$/',],
        ], [
            'name.regex' => 'The :attribute is invalid. Only letters and spaces are allowed.',
            'phone.digits_between' => $request->phone." field is invalid should have 10 numbers",
        ]);
        
        $add_quizuser = new User;
        $add_quizuser->name = $request->name;
        $add_quizuser->email = strtolower($request->email);
        $add_quizuser->phone = $request->phone;
        $add_quizuser->by_prj_manager_id = auth()->user()->id;
        $add_quizuser->address = 'dummy address';
        $add_quizuser->role = 5;
        $add_quizuser->status = 'active';
        $add_quizuser->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        $add_quizuser -> save();
        
        if ($add_quizuser) {
            $add_user_quizregistrations = new Courseregistrations;
            $add_user_quizregistrations->user_id = $add_quizuser->id;
            $add_user_quizregistrations->course_id = $request->quiz_id;
            $add_user_quizregistrations->by_prj_manager_id = auth()->user()->id;
            $course_details = Courses::findOrFail($request->quiz_id);
    
            // Loop through module details and assign them dynamically
            for ($i = 1; $i <= 15; $i++) {
                $module_field = 'module_' . $i;
                $quiz_field = 'module_' . $i . '_quiz';
                $completion_field = 'module_' . $i . '_completion_percentage';
                if ($course_details->$module_field != null) {
                    $add_user_quizregistrations->$module_field = $course_details->$module_field;
                    $add_user_quizregistrations->$quiz_field = $course_details->$quiz_field;
                    $add_user_quizregistrations->$completion_field = $course_details->$completion_field;
                }
            }

        }
    
        // Save the user quiz registration
        $add_user_quizregistrations->save();
    
        if ($add_user_quizregistrations) {
            return redirect()->route('projectleader.manageuserslist')->with('success','User Added Successfully');
        }else{
            return redirect()->route('projectleader.manageuserslist')->with('danger','Sorry User not created , try again later');
        }
    }
    public function createuser_old(Request $request){

        $request->validate([
            'name' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric','digits_between:10,10', 'unique:users,phone','regex:/^[0-9]+$/',],
        ], [
            'name.regex' => 'The :attribute is invalid. Only letters and spaces are allowed.',
            'phone.digits_between' => $request->phone." field is invalid should have 10 numbers",
        ]);
        
        $add_quizuser = new User;
        $add_quizuser->name = $request->name;
        $add_quizuser->email = strtolower($request->email);
        $add_quizuser->phone = $request->phone;
        $add_quizuser->address = 'dummy address';
        $add_quizuser->role = 5;
        $add_quizuser->status = 'active';
        $add_quizuser->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        
        $add_quizuser -> save();

        if($add_quizuser){

            return redirect()->route('projectleader.manageuserslist')->with('success','User Added Successfully');
        }else{
            return redirect()->route('projectleader.manageuserslist')->with('danger','Sorry User not created , try again later');
        }

    }


    public function edituser(Request $request){
        
        $request -> validate([
            'name' => ['required', 'min:4', 'max:50', 'regex:/^[a-zA-Z ]*$/'],
            'email' => "required|email",
            'phone' => ['required', 'numeric','digits_between:10,10','regex:/^[0-9]+$/',],
        ],[
            'name.regex' => $request->name." is invalid only letters and space is allowed.",
            'phone.digits_between' => $request->phone." field is invalid should have 10 numbers",
        ]);

        $update_user_id = $request->id;
        
        $update_user =  User::findOrFail($update_user_id);
        // $pincode_id =  Pincodes::findOrFail($request->pincode);
        
        $update_user -> name =  $request->name;
        $update_user->email = strtolower($request->email);
        $update_user -> phone =  $request->phone;
        $update_user -> save();
        
        if($update_user){
            return redirect()->route('projectleader.manageuserslist')->with('success', "User <b>$update_user->name</b> updated successfully");
        }else{
            return  redirect()->route('projectleader.manageuserslist')->with('fail',"User <b>$update_user->name</b> update failed, try again later");
        }

    
    }

    public function deleteuser(Request $request){
        $request -> validate([
            'id' => "required|exists:users,id",
        ],[
            'id.exists' => 'Sorry, Project Manager Id does not exist',
        ]);        

        $deleteuser = User::find($request->id);

        $deleteuser->delete();
    
        if($deleteuser){
            return  redirect()->route('projectleader.manageuserslist')->with('success',"User <b>$deleteuser->name</b> is removed successfully");
        }else{
            return  redirect()->route('projectleader.manageuserslist')->with('fail',"User <b>$deleteuser->name</b> is not removed , try again later");
        }

    }

    // resources manage section
    public function view_resources(){
        $resourcesdata = Resources::where('createdby_user_id', auth()->user()->id)->get();

        return view('projectleader.quiz.resources',['resourcesdatalist' => $resourcesdata]);

    }

    // Add Resources
    public function add_resources(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'resource_name' => 'required|string|max:255',
            'resource_type' => 'required|string|in:image,video,pdf',
        ]);

        // If validation for the main fields fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Apply validation rules based on resource type
        if ($request->resource_type === 'image') {
            $validator = Validator::make($request->all(), [
                'resource_file' => 'required|file|image',
            ]);
        } elseif ($request->resource_type === 'video') {
            $validator = Validator::make($request->all(), [
                'resource_file' => 'required|file|max:524288|mimetypes:video/*', // Validate as a file and accept any video MIME type
            ]);
        } elseif ($request->resource_type === 'pdf') {
            $validator = Validator::make($request->all(), [
                'resource_file' => 'required',
            ]);
        }

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            // If validation passes, create and store the resource
            // Store the uploaded file in the 'test' folder
        $path = $request->file('resource_file')->store('test/videos');

        // Get the SproutVideo folder ID (replace 'FOLDER_ID' with the actual folder ID)
        $folderId = '1c9fdeb61512e592';

        // Upload the video to SproutVideo
        $response = SproutVideo\Video::create_video(storage_path('app/' . $path), [
            'folder_id' => $folderId,
            'privacy' => 2, // Set privacy level to public
            'download_hd' => true,   // Enable HD download
            'download_sd' => true,   // Enable SD download
            'download_source' => true,   // Enable SD download
        ]);

        

        $downloadUrl = 'https://heartfailurefaq.vids.io/videos/'.$response['id'].'/'.$response['title'];
        
        if($response){
            // Remove the video from the local test folder
            Storage::delete($path);

                $resource = new Resources();
                $resource->resource_name = $request->resource_name;
                $resource->resource_type = $request->resource_type;
                $resource->from_id = auth()->user()->id;
                $resource->from_name = auth()->user()->name;
                $resource->from_email = auth()->user()->email;
                $resource->from_phone = auth()->user()->phone;
                $resource->from_role = auth()->user()->role;
                $resource->createdby_user_id = auth()->user()->id;
                $resource->createdby_user_name = auth()->user()->name;
                $resource->createdby_user_email = auth()->user()->email;
                $resource->createdby_user_phone = auth()->user()->phone;
                $resource->createdby_user_role = auth()->user()->role;
                $resource->resource_cover_img = 'null';
                $resource->resource_path = $response['embed_code'];
            
                $resource->save();

                if($resource){
                    // Redirect or return response
                    return redirect()->back()->with('success', 'Resource created successfully!');
                }else{
                    return redirect()->back()->with('danger', 'Resource not created. Code : #6554, please try after some time ');
                }

        }
    }
   
    public function edit_resources(Request $request)
    {
       // Validation rules
       $validator = Validator::make($request->all(), [
        'id' => 'required|exists:resources,id',
        'resource_name' => 'required|string|max:255',
    ]);

    // If validation for the main fields fails, redirect back with errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // If validation fails, redirect back with errors
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

        // If validation passes, create and store the resource
        $resource_update =  Resources::findOrFail($request->id);
        $resource_update->resource_name = $request->resource_name;
        $resource_update->from_id = auth()->user()->id;
        $resource_update->from_name = auth()->user()->name;
        $resource_update->from_email = auth()->user()->email;
        $resource_update->from_phone = auth()->user()->phone;
        $resource_update->from_role = auth()->user()->role;
        $resource_update->updatedby_user_id = auth()->user()->id;
        $resource_update->updatedby_user_name = auth()->user()->name;
        $resource_update->updatedby_user_email = auth()->user()->email;
        $resource_update->updatedby_user_phone = auth()->user()->phone;
        $resource_update->updatedby_user_role = auth()->user()->role;
        $resource_update->save();
        
        // Redirect or return response
        return redirect()->back()->with('success', 'Resource updated successfully!');
    }

    public function delete_resources(Request $request){
        $request -> validate([
            'id' => 'required|exists:resources,id',
        ],[
            'id.exists' => 'Sorry, Resource Id does not exist',
        ]);        

        $deleteresource = Resources::find($request->id);

        $deleteresource->delete();
    
        if($deleteresource){
            return  redirect()->route('projectleader.resources')->with('success',"Resource :  <b>$deleteresource->resource_name</b> is removed successfully");
        }else{
            return  redirect()->route('projectleader.resources')->with('fail',"Resource <b>$deleteresource->resource_name</b> is not removed , try again later");
        }

    }

    public function manageresourcestatus(Request $request){
        $request -> validate([
            'id' => "required|numeric",
        ]);

        $update_resource_status =  Resources::findOrFail($request->id);
        $update_resource_status->resource_status = ($update_resource_status->resource_status == 'active') ? 'inactive' : 'active';
        $update_resource_status->save();
        
        if($update_resource_status){
            return redirect()->route('projectleader.resources')->with('success', "Resource <b>$update_resource_status->resource_name</b> status updated successfully");
        }else{
            return  redirect()->route('projectleader.resources')->with('fail',"Resource <b>$update_resource_status->resource_name</b> status update failed, try again later");
        }

    
    }

    // quiz manage section
    public function view_quizs(){
        $quizdata = Courses::where('createdby_user_id',auth()->user()->id)->get();
        $resourcesdata = Resources::all();
        return view('projectleader.quiz.quizs',['quizdatalist' => $quizdata]);

    }
   
    public function add_quiz(Request $request){
        // dd($request);

        // Validation rules for the quiz
        $rules = [
            'quiz_name' => 'required|string|max:255',
        ];

        // Validate the request data
        $validatedData = $request->validate($rules);

        // Process and transform the validated data for storage in the database
        $quizName = $validatedData['quiz_name'];
        
        // Store the transformed data in the database
        $quiz = new Courses();
        $quiz->course_name = $quizName;
        // Iterate over the request data to handle modules dynamically
        $moduleCount = 0;
        foreach ($request->all() as $key => $value) {
            if (strpos($key, '_completion_percentage') !== false) {
                $moduleCount++;
            }
        }

        // dd($moduleCount);
        
        for ($i = 1; $i <= $moduleCount; $i++) {
            $moduleKey = "module_$i";
            $moduleQuizKey = "module_${i}_quiz";
            $moduleCompletionPercentageKey = "module_${i}_completion_percentage";

            $quiz->$moduleKey = $request->$moduleKey;
            $quiz->$moduleQuizKey = json_encode($request->$moduleQuizKey);
            $quiz->$moduleCompletionPercentageKey = $request->$moduleCompletionPercentageKey;
        }
        $quiz->updatedby_user_id = auth()->user()->id;
        $quiz->updatedby_user_name = auth()->user()->name;
        $quiz->updatedby_user_email = auth()->user()->email;
        $quiz->updatedby_user_phone = auth()->user()->phone;
        $quiz->updatedby_user_role = auth()->user()->role;
        $quiz->createdby_user_id = auth()->user()->id;
        $quiz->createdby_user_name = auth()->user()->name;
        $quiz->createdby_user_email = auth()->user()->email;
        $quiz->createdby_user_phone = auth()->user()->phone;
        $quiz->createdby_user_role = auth()->user()->role;
        $quiz->save();

        if($quiz){
            return redirect()->back()->with('success', 'Course created successfully!');
        }else{
            return redirect()->back()->with('danger', 'Course not created, please try agin later!');
        }


    }
    public function add_quiz_v2(Request $request){
        // dd($request);

        // Validation rules for the quiz
        $rules = [
            'quiz_name' => 'required|string|max:255',
            'modules' => 'required|array',
            // 'modules.*.module_name' => 'required|string|max:255',
            // 'modules.*.module_order' => 'required|integer',
            // 'mcqs' => 'required|array',
            // 'mcqs.*.question' => 'required|string|max:255',
            // 'mcqs.*.options' => 'required|array|min:4', // Assuming there are at least 4 options for each question
            // 'mcqs.*.correct_answer' => 'required|integer|min:1|max:4' // Assuming correct answer is between 1 and 4
        ];

            // Validate the request data
        $validatedData = $request->validate($rules);

        // Process and transform the validated data for storage in the database
        $quizName = $validatedData['quiz_name'];
        $modules = json_encode($validatedData['modules']);
        // $mcqs = json_encode($validatedData['mcqs']);

        // Store the transformed data in the database
        $quiz = new Quizs();
        $quiz->quiz_name = $quizName;
        $quiz->quiz_modules = $modules;
        $quiz->quiz_content = 'null';
        $quiz->updatedby_user_id = auth()->user()->id;
        $quiz->updatedby_user_name = auth()->user()->name;
        $quiz->updatedby_user_email = auth()->user()->email;
        $quiz->updatedby_user_phone = auth()->user()->phone;
        $quiz->updatedby_user_role = auth()->user()->role;
        $quiz->createdby_user_id = auth()->user()->id;
        $quiz->createdby_user_name = auth()->user()->name;
        $quiz->createdby_user_email = auth()->user()->email;
        $quiz->createdby_user_phone = auth()->user()->phone;
        $quiz->createdby_user_role = auth()->user()->role;
        $quiz->save();

        if($quiz){
            return redirect()->back()->with('success', 'Quiz created successfully!');
        }else{
            return redirect()->back()->with('danger', 'Quiz not created, please try agin later!');
        }


    }
    public function edit_quiz(Request $request){

        // Validation rules for the quiz
        $rules = [
            'id' => 'required|exists:courses,id',
            'quiz_name' => 'required|string|max:255',
            'modules' => 'required|array',
            // 'modules.*.module_name' => 'required|string|max:255',
            // 'modules.*.module_order' => 'required|integer',
            // 'mcqs' => 'required|array',
            // 'mcqs.*.question' => 'required|string|max:255',
            // 'mcqs.*.options' => 'required|array|min:4', // Assuming there are at least 4 options for each question
            // 'mcqs.*.correct_answer' => 'required|integer|min:1|max:4' // Assuming correct answer is between 1 and 4
        ];

            // Validate the request data
        $validatedData = $request->validate($rules);

        // Process and transform the validated data for storage in the database
        $quizName = $validatedData['quiz_name'];
        $modules = json_encode($validatedData['modules']);
        // $mcqs = json_encode($validatedData['mcqs']);

        // Store the transformed data in the database
        
        $quiz_update =  Courses::findOrFail($request->id);
        $quiz_update->quiz_name = $quizName;
        $quiz_update->quiz_modules = $modules;
        $quiz_update->quiz_content = 'null';
        $quiz_update->quiz_status = $request->quiz_status;
        $quiz_update->updatedby_user_id = auth()->user()->id;
        $quiz_update->updatedby_user_name = auth()->user()->name;
        $quiz_update->updatedby_user_email = auth()->user()->email;
        $quiz_update->updatedby_user_phone = auth()->user()->phone;
        $quiz_update->updatedby_user_role = auth()->user()->role;
        $quiz_update->save();

        if($quiz_update){
            return redirect()->back()->with('success', 'Quiz updated successfully!');
        }else{
            return redirect()->back()->with('danger', 'Quiz not updated, please try agin later!');
        }


    }

    public function change_user_course(Request $request){
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id'],
        ]);
        
            $course_details = Courses::findOrFail($request->course_id);
            
            $delete_user_course_registrations = Courseregistrations::where('user_id', $request->user_id)->delete();

            if ($delete_user_course_registrations === 0) {
                return redirect()->back()->with('danger','User Course not updated');
            }

            $add_update_user_quizregistrations = new Courseregistrations;
            $add_update_user_quizregistrations->user_id = $request->user_id;
            $add_update_user_quizregistrations->course_id = $request->course_id;
            $add_update_user_quizregistrations->by_prj_manager_id = auth()->user()->id;
    
            // Loop through module details and assign them dynamically
            for ($i = 1; $i <= 15; $i++) {
                $module_field = 'module_' . $i;
                $quiz_field = 'module_' . $i . '_quiz';
                $completion_field = 'module_' . $i . '_completion_percentage';
                if ($course_details->$module_field != null) {
                    $add_update_user_quizregistrations->$module_field = $course_details->$module_field;
                    $add_update_user_quizregistrations->$quiz_field = $course_details->$quiz_field;
                    $add_update_user_quizregistrations->$completion_field = $course_details->$completion_field;
                }
            

        }
    
        // Save the user quiz registration
        $add_update_user_quizregistrations->save();
    
        if ($add_update_user_quizregistrations) {
            return redirect()->route('projectleader.manageuserslist')->with('success','User course updated successfully');
        }else{
            return redirect()->route('projectleader.manageuserslist')->with('danger','Sorry user course not updated, try again later');
        }


    }


    
    public function delete_quiz(Request $request){

        $request -> validate([
            'id' => 'required|exists:courses,id',
        ],[
            'id.exists' => 'Sorry, Quiz Id does not exist',
        ]);        

        $deletequiz = Courses::find($request->id);

        $deletequiz->delete();
    
        if($deletequiz){
            return  redirect()->route('projectleader.quizs')->with('success',"Course :  <b>$deletequiz->course_name</b> is removed successfully");
        }else{
            return  redirect()->route('projectleader.quizs')->with('fail',"Course <b>$deletequiz->course_name</b> is not removed , try again later");
        }


    }

    public function managecourcestatus(Request $request){
        $request -> validate([
            'id' => "required|numeric",
        ]);

        $update_cources_status =  Courses::findOrFail($request->id);
        $update_cources_status->cources_status = ($update_cources_status->cources_status == 'active') ? 'inactive' : 'active';
        $update_cources_status->save();
        
        if($update_cources_status){
            return redirect()->route('projectleader.quizs')->with('success', "Cource  <b>$update_cources_status->course_name</b> status updated successfully");
        }else{
            return  redirect()->route('projectleader.quizs')->with('fail',"Cource <b>$update_cources_status->resource_name</b> status update failed, try again later");
        }

    
    }

    public function appointment_scheduling(){
        $appointment_detail = Appointments::where('project_manager_id', auth()->user()->id)->first();

        return view('projectleader.appointment_scheduling',['appointment_detail' => $appointment_detail]); 
    }

    public function store_appointment(Request $request){
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            // Validation rule for time slots
            'time_slot_1' => 'required|different:time_slot_2|different:time_slot_3',
            'time_slot_2' => 'required|different:time_slot_1|different:time_slot_3',
            'time_slot_3' => 'required|different:time_slot_1|different:time_slot_2',
        ]);

        // Create a new appointment instance
        $appointment = new Appointments();
        $appointment->project_manager_id = auth()->user()->id;
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->time_slot_1 = $request->input('time_slot_1');
        $appointment->time_slot_2 = $request->input('time_slot_2');
        $appointment->time_slot_3 = $request->input('time_slot_3');

        // Save the appointment
        $appointment->save();

        
        if($appointment){
            return redirect()->back()->with('success', "Appointment scheduled successfully");
        }else{
            return  redirect()->back()->with('fail',"Sorry your appointment was not booked, try again later");
        }

    
    }
    public function  update_appointment_scheduling(Request $request, $id){
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            // Validation rule for time slots
            'time_slot_1' => 'nullable|different:time_slot_2|different:time_slot_3',
            'time_slot_2' => 'nullable|different:time_slot_1|different:time_slot_3',
            'time_slot_3' => 'nullable|different:time_slot_1|different:time_slot_2',
        ]);
    
        $appointment = Appointments::findOrFail($id);
        $appointment->project_manager_id = auth()->user()->id;
        $appointment->appointment_date = $request->input('appointment_date');
        $appointment->time_slot_1 = $request->input('time_slot_1');
        $appointment->time_slot_2 = $request->input('time_slot_2');
        $appointment->time_slot_3 = $request->input('time_slot_3');
    
        // Save the appointment
        $saved = $appointment->save();
    
        if ($saved) {
            return redirect()->back()->with('success', "Appointment updated successfully");
        } else {
            return redirect()->back()->with('fail', "Sorry, the appointment could not be updated");
        }
    }

    public function createOrUpdate(Request $request, $id = null)
    {
        $data = $request->validate([
            'appointment_section_1_date' => 'nullable|date',
            'section_1_time_slot_1' => 'nullable|date_format:H:i',
            'section_1_time_slot_2' => 'nullable|date_format:H:i',
            'section_1_time_slot_3' => 'nullable|date_format:H:i',
            'appointment_section_2_date' => 'nullable|date',
            'section_2_time_slot_1' => 'nullable|date_format:H:i',
            'section_2_time_slot_2' => 'nullable|date_format:H:i',
            'section_2_time_slot_3' => 'nullable|date_format:H:i',
            'appointment_section_3_date' => 'nullable|date',
            'section_3_time_slot_1' => 'nullable|date_format:H:i',
            'section_3_time_slot_2' => 'nullable|date_format:H:i',
            'section_3_time_slot_3' => 'nullable|date_format:H:i',
        ]);

        $projectManagerId = auth()->user()->id;

        // Check for existing appointments with the same dates
        $existingAppointments = Appointments::where('project_manager_id', $projectManagerId)
            ->where(function ($query) use ($data) {
                if (isset($data['appointment_section_1_date'])) {
                    $query->orWhere('appointment_section_1_date', $data['appointment_section_1_date'])
                        ->orWhere('appointment_section_2_date', $data['appointment_section_1_date'])
                        ->orWhere('appointment_section_3_date', $data['appointment_section_1_date']);
                }
                if (isset($data['appointment_section_2_date'])) {
                    $query->orWhere('appointment_section_1_date', $data['appointment_section_2_date'])
                        ->orWhere('appointment_section_2_date', $data['appointment_section_2_date'])
                        ->orWhere('appointment_section_3_date', $data['appointment_section_2_date']);
                }
                if (isset($data['appointment_section_3_date'])) {
                    $query->orWhere('appointment_section_1_date', $data['appointment_section_3_date'])
                        ->orWhere('appointment_section_2_date', $data['appointment_section_3_date'])
                        ->orWhere('appointment_section_3_date', $data['appointment_section_3_date']);
                }
            })
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->exists();

        if ($existingAppointments) {
            return redirect()->back()->withErrors(['danger' => 'The selected date is already booked. Please choose another date.']);
        }

        $appointment = $id ? Appointments::findOrFail($id) : new Appointments();
        $appointment->project_manager_id = $projectManagerId;

        if(isset($data['appointment_section_1_date'])){
            $appointment->appointment_section_1_date = $data['appointment_section_1_date'];
            $appointment->appointment_section_1_booking = 'yes';
            $appointment->section_1_time_slot_1 = $data['section_1_time_slot_1'] ?? null;
            $appointment->section_1_time_slot_2 = $data['section_1_time_slot_2'] ?? null;
            $appointment->section_1_time_slot_3 = $data['section_1_time_slot_3'] ?? null;
        }

        if(isset($data['appointment_section_2_date'])){
            $appointment->appointment_section_2_date = $data['appointment_section_2_date'];
            $appointment->appointment_section_2_booking = 'yes';
            $appointment->section_2_time_slot_1 = $data['section_2_time_slot_1'] ?? null;
            $appointment->section_2_time_slot_2 = $data['section_2_time_slot_2'] ?? null;
            $appointment->section_2_time_slot_3 = $data['section_2_time_slot_3'] ?? null;
        }

        if(isset($data['appointment_section_3_date'])){
            $appointment->appointment_section_3_date = $data['appointment_section_3_date'];
            $appointment->appointment_section_3_booking = 'yes';
            $appointment->section_3_time_slot_1 = $data['section_3_time_slot_1'] ?? null;
            $appointment->section_3_time_slot_2 = $data['section_3_time_slot_2'] ?? null;
            $appointment->section_3_time_slot_3 = $data['section_3_time_slot_3'] ?? null;
        }

        $appointment->save();

        $message = $id ? 'Appointment updated successfully' : 'Appointment scheduled successfully';
        return redirect()->back()->with('success', $message);
    }


    public function booked_appointment_users_list(){
        $appointment_booked_detail = Registrations::where('project_manager_id', auth()->user()->id)->get();
        return view('projectleader.appointment_booked_list',['appointment_booked_detail' => $appointment_booked_detail]); 
    }

    public function update_zoom_detail_appointment_users_list(Request $request){
        $request->validate([
            'date_time_slot_id' => 'required',
            'zoom_details' => 'required'
          ]);

        // Assuming the input date and time string is coming from a request input field
        $inputString = $request->input('date_time_slot_id'); // For example, '16-May-2024 | 15:40'

        // Correctly split the input string using explode
        $date_time_slot_id = explode('|', $inputString);

        $appointment_date = trim($date_time_slot_id[0]);
        $appointment_timeslot = trim($date_time_slot_id[1]);
      
        // Find all matching appointment details
        $update_registrations =  Registrations::where('project_manager_id', auth()->user()->id)
        ->where('appointment_date', $appointment_date)
        ->where('appointment_time', $appointment_timeslot)
        ->get();

        // Update all matching records
        $updatedRows = $update_registrations->count();
        if ($updatedRows > 0) {
            Registrations::where('project_manager_id', auth()->user()->id)
                ->where('appointment_date', $appointment_date)
                ->where('appointment_time', $appointment_timeslot)
                ->where('appointment_status', 'booked')
                ->update([
                    'zoom_details' => $request->input('zoom_details'),
                    'appointment_status' => 'confirmed'
                ]);

        // Send emails to each user
        foreach ($update_registrations as $registrationItem) {
            // Mail::to($registrationItem->user->email)->send(new ZoomDetailsUpdated($registration));
            $user_detail_for_zoom_detail = User::where('id', $registrationItem->user_id)->first();
            Mail::to($user_detail_for_zoom_detail->email)->send(new ZoomDetailsUpdated($registrationItem));
        }
        
        if($update_registrations){
            return redirect()->back()->with('success', "Zoom Details updated  successfully");
        }else{
            return  redirect()->back()->with('fail',"Sorry your Zoom Details was not booked, try again later");
        }
    
     }
    }


    public function feedbacks(){
        $feedback_detail = Courseregistrations::whereNotNull('feedback')->where('by_prj_manager_id', auth()->user()->id)->get();

        return view('projectleader.usersfeedback_list',['feedback_detail' => $feedback_detail]); 
    }


    // user for quiz section

    public function user_dashboard()
    {
        $registered_course_detail = Courseregistrations::where('user_id', auth()->user()->id)->first();

        // Check if the user is registered for any course
        if (!$registered_course_detail) {
            $registered_course_detail = $this->start_new_user_quiz(); 
        }

        $course_detail = Courses::where('id', $registered_course_detail->course_id)->first();

        return view('campexecutive.home', [
            'registered_course_detail' => $registered_course_detail,
            'course_detail' => $course_detail
        ]);
    }

    private function start_new_user_quiz()
    {
        $course_details = Courses::findOrFail(8);

        $registration = new Courseregistrations;
        $registration->user_id = auth()->user()->id;
        $registration->course_id = $course_details->id;
        $registration->by_prj_manager_id = auth()->user()->by_prj_manager_id;

        // Loop through module details and assign them dynamically
        for ($i = 1; $i <= 15; $i++) {
            $module_field = 'module_' . $i;
            $quiz_field = 'module_' . $i . '_quiz';
            $completion_field = 'module_' . $i . '_completion_percentage';

            if (!empty($course_details->$module_field)) {
                $registration->$module_field = $course_details->$module_field;
                $registration->$quiz_field = $course_details->$quiz_field;
                $registration->$completion_field = $course_details->$completion_field;
            }
        }

        $registration->save();

        return $registration;
    }

    
    public function user_dashboard_old(){
        
        $registered_course_detail = Courseregistrations::where('user_id', auth()->user()->id)->first();
        $course_detail = Courses::where('id', $registered_course_detail->course_id)->first();
        
        return view('campexecutive.home',['registered_course_detail' => $registered_course_detail,'course_detail' => $course_detail]); 
    }
    
    public function submit_course_result(Request $request){

        // Perform validation
        if (empty($request->courseid) || !Quizregistrations::find($request->courseid)) {
            return 'Invalid course ID';
        } elseif (!is_numeric($request->score) || !is_numeric($request->totalQuestions)) {
            return 'Score must be numeric, Total questions must be numeric';
        } elseif (!in_array($request->passFail, ['pass', 'fail'])) {
            return 'Pass/Fail must be either Pass or Fail';
        } else {
            $update_user_course_result = Quizregistrations::find($request->courseid);

            $update_user_course_result->quiz_status = 'completed';
            $update_user_course_result->quiz_result = $request->passFail;
            $update_user_course_result->quiz_marks = $request->score;
            $update_user_course_result->quiz_totalquestions = $request->totalQuestions;

            $update_user_course_result -> save();

            if ($update_user_course_result) {
                return '1111'; 
                
            } else {
                return '0000'; 
                
            }
        }
         
    }
    public function submit_course_result_v2(Request $request){
        // Perform validation
        if (!Courseregistrations::where('user_id', auth()->user()->id)->first()) {
            return 'Invalid course ID';
        } else {
            $i = $request['module_name'];

            $update_user_course_result = Courseregistrations::where('user_id', auth()->user()->id)->first();
 
            // Decode the JSON string into an associative array
            $correctAnswers = json_decode($update_user_course_result->{$i . '_quiz'}, true);

            // Initialize a variable to count the number of correct responses
            $correctCount = 0;
            $totalQuestions = count($request[$i.'_quiz']);

            $questionData = [];

            // Loop through each question and check the user's response
            foreach ($request[$i.'_quiz'] as $questionKey => $userSelected) {
                preg_match('/\d+/', $questionKey, $matches);
                $questionNumber = $matches[0];
                $correctAnswer = $correctAnswers['mcqs'][$questionNumber]['correct_answer'];
                $correctOptionName = $correctAnswers['mcqs'][$questionNumber]['options'][$correctAnswer-1];
                $userSelectedOptionName = $correctAnswers['mcqs'][$questionNumber]['options'][$userSelected-1];
                $question = $correctAnswers['mcqs'][$questionNumber]['question'];
                $correctAnswerExplanation = $correctAnswers['mcqs'][$questionNumber]['correct_answer_explanation'];
            
                // Update the user_selected_option
                $correctAnswers['mcqs'][$questionNumber]['user_selected_option'] = $userSelected;
                
                // Store the question, user selected option, and correct option in an array
                $questionData[] = [
                    'question' => $question,
                    'user_selected_option' => $userSelected,
                    'user_selected_option_name' => $userSelectedOptionName,
                    'correct_option' => $correctAnswer,
                    'correct_option_name' => $correctOptionName,
                    'correct_answer_explanation' => $correctAnswerExplanation
                ];
            
                if ($userSelected === $correctAnswer) {
                    $correctCount++; // Increment the count if the response is correct
                }
            }

            // Calculate the percentage of correct answers
            $percentage = ($correctCount / $totalQuestions) * 100;

            // Update the completion percentage, completion status, and attempt count
            $update_user_course_result->{$i . '_completed'} = ($percentage >= $update_user_course_result->{$i . '_completion_percentage'}) ? "yes" : "no";
            $update_user_course_result->{$i . '_attempt'}  += ($percentage >= $update_user_course_result->{$i . '_completion_percentage'}) ? 0 : 1;

            // Save the updated user responses back to the database
            $update_user_course_result->module_1_quiz = json_encode($correctAnswers);

            // Set the session variables
            session(['correctCount' => $correctCount, 'percentage' => $percentage]);
            
            if($update_user_course_result->{$i . '_completed'}== 'yes'){
                session(['Module_Completed' => 'Success', 'moduleRemarks' => $i.' Completed', 'moduleAlert' => 'success']);
                session(['questionData' => $questionData]); // Store question data in session

            }
            
            if($update_user_course_result->{$i . '_completed'}== 'no'){
                session(['Module_Completed' => 'Error', 'moduleRemarks' => $i.' Sorry, wrong answer, Please try again', 'moduleAlert' => 'error']);
                session(['questionData' => $questionData]); // Store question data in session
            }
            
            
            
                // Generate_Certificate
                if($update_user_course_result->module_1_completed == 'yes'){

                    $sourceImagePath = storage_path('app/public/Certificate_dummy.jpg');
                    $sourceImage = imagecreatefromjpeg($sourceImagePath);
    
                    // Set the font color (Black)
                    $fontColor = imagecolorallocate($sourceImage, 0, 0, 0); 
    
                    // Set the font path and size
                    $fontPath = public_path('arial.ttf'); 
                    $fontSize = 120;
    
                    // Set the text to be written on the image
                    $text = auth()->user()->name;
    
                    // Calculate the position to place the text (center horizontally and vertically)
                    $textWidth = imagettfbbox($fontSize, 0, $fontPath, $text);
                    $textWidth = $textWidth[2] - $textWidth[0];
                    $textHeight = imagettfbbox($fontSize, 0, $fontPath, $text);
                    $textHeight = $textHeight[1] - $textHeight[7];
                    $x = (imagesx($sourceImage) - $textWidth) / 2; // Center horizontally
                    $y = (imagesy($sourceImage) + $textHeight) / 2; // Center vertically
    
                    // Add text to the image
                    imagettftext($sourceImage, $fontSize, 0, $x, $y, $fontColor, $fontPath, $text);
    
                    // Generate a unique filename with timestamp
                    $newImageFilename = auth()->user()->id.'_' . time() . '.jpg';
    
                    // Save the modified image to the same storage folder
                    $newImagePath = storage_path('app/public/course_certificate/' . $newImageFilename);
                    imagejpeg($sourceImage, $newImagePath);
                    
                    $update_user_course_result->course_certificate_path = $newImageFilename;

    
                }
                
                $update_user_course_result -> save();

                // Redirect back with success message
                return redirect()->back();
                
            
        }
         
    }
    

    public function submit_course_result_v3(Request $request){
        // Perform validation
        if (!Courseregistrations::where('user_id', auth()->user()->id)->first()) {
            return 'Invalid course ID';
        } else {
            $i = $request['module_name'];

            $update_user_course_result = Courseregistrations::where('user_id', auth()->user()->id)->first();
 
            // Decode the JSON string into an associative array
            $correctAnswers = json_decode($update_user_course_result->{$i . '_quiz'}, true);

            // Initialize a variable to count the number of correct responses
            $correctCount = 0;
            $totalQuestions = count($request[$i.'_quiz']);

            $questionData = [];

            // Loop through each question and check the user's response
            foreach ($request[$i.'_quiz'] as $questionKey => $userSelected) {
                preg_match('/\d+/', $questionKey, $matches);
                $questionNumber = $matches[0];
                $correctAnswer = $correctAnswers['mcqs'][$questionNumber]['correct_answer'];
                $correctOptionName = $correctAnswers['mcqs'][$questionNumber]['options'][$correctAnswer-1];
                $userSelectedOptionName = $correctAnswers['mcqs'][$questionNumber]['options'][$userSelected-1];
                $question = $correctAnswers['mcqs'][$questionNumber]['question'];
                $correctAnswerExplanation = $correctAnswers['mcqs'][$questionNumber]['correct_answer_explanation'];
            
                // Update the user_selected_option
                $correctAnswers['mcqs'][$questionNumber]['user_selected_option'] = $userSelected;
                
                // Store the question, user selected option, and correct option in an array
                $questionData[] = [
                    'question' => $question,
                    'user_selected_option' => $userSelected,
                    'user_selected_option_name' => $userSelectedOptionName,
                    'correct_option' => $correctAnswer,
                    'correct_option_name' => $correctOptionName,
                    'correct_answer_explanation' => $correctAnswerExplanation
                ];
            
                if ($userSelected === $correctAnswer) {
                    $correctCount++; // Increment the count if the response is correct
                }
            }

            // Calculate the percentage of correct answers
            $percentage = ($correctCount / $totalQuestions) * 100;

            // Update the completion percentage, completion status, and attempt count
            $update_user_course_result->{$i . '_completed'} = ($percentage >= $update_user_course_result->{$i . '_completion_percentage'}) ? "yes" : "no";
            $update_user_course_result->{$i . '_attempt'}  += ($percentage >= $update_user_course_result->{$i . '_completion_percentage'}) ? 0 : 1;

            // Save the updated user responses back to the database
            $update_user_course_result->{$i . '_quiz'}  = json_encode($correctAnswers);

            // Set the session variables
            session(['correctCount' => $correctCount, 'percentage' => $percentage]);
            
            if($update_user_course_result->{$i . '_completed'}== 'yes'){
                session(['Module_Completed' => 'Success', 'moduleRemarks' => $i.' Completed', 'moduleAlert' => 'success']);
                session(['questionData' => $questionData]); // Store question data in session

            }
            
            if($update_user_course_result->{$i . '_completed'}== 'no'){
                session(['Module_Completed' => 'Error', 'moduleRemarks' => $i.' Sorry, wrong answer, Please try again', 'moduleAlert' => 'error']);
                session(['questionData' => $questionData]); // Store question data in session
            }
            
            
            
            // Complete Course update
            if($update_user_course_result->module_6_completed == 'yes'){
                $update_user_course_result->course_status = 'completed';
                $update_user_course_result->course_result = 'pass';
            }

            
            $update_user_course_result -> save();

            // Redirect back with success message
            return redirect()->back();
                
            
        }
         
    }

    
    public function generateImage()
    {
        // Load the image
        $sourceImagePath = storage_path('app/public/Certificate_dummy.jpg');
        $sourceImage = imagecreatefromjpeg($sourceImagePath);
        
            // Set the font color (Black)
            $fontColor = imagecolorallocate($sourceImage, 0, 0, 0); 

        // Set the font path and size
        $fontPath = public_path('arial.ttf'); 
        $fontSize = 120;

        // Set the text to be written on the image
        $text = auth()->user()->name;

        // Calculate the position to place the text (center horizontally and vertically)
        $textWidth = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textWidth = $textWidth[2] - $textWidth[0];
        $textHeight = imagettfbbox($fontSize, 0, $fontPath, $text);
        $textHeight = $textHeight[1] - $textHeight[7];
        $x = (imagesx($sourceImage) - $textWidth) / 2; // Center horizontally
        $y = (imagesy($sourceImage) + $textHeight) / 2; // Center vertically
        
        // Add text to the image
        imagettftext($sourceImage, $fontSize, 0, $x, $y, $fontColor, $fontPath, $text);
        
        // Generate a unique filename with timestamp
        $newImageFilename = auth()->user()->id.'_' . time() . '.jpg';
        
        // Save the modified image to the same storage folder
        $newImagePath = storage_path('app/public/course_certificate/' . $newImageFilename);
        imagejpeg($sourceImage, $newImagePath);
        
        // // Destroy the image resource to free up memory
        // imagedestroy($sourceImage);
        
        // Return the new image path
        return $newImagePath;
    }


    public function submit_user_feedback(Request $request){
        // Validate the incoming request data
        $request->validate([
            'Feedback' => 'required|array',
            'Feedback.*.quest' => 'required|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
            'Feedback.q1.feedQ1' => 'required|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
            'Feedback.q2.feedQ2' => 'required|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
            'Feedback.q3.feedQ3' => 'required|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
            'Feedback.feedQ4' => 'nullable|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
            'Feedback.q5.feedQ5' => 'required|string|in:Yes,No',
            'Feedback.q6.feedQ6' => 'nullable|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
            'Feedback.q6.feedQ7' => 'nullable|string|regex:/^[0-9]+$/',
            'Feedback.q6.feedQ8' => 'nullable|email',
            'Feedback.q6.feedQ9' => 'nullable|string|regex:/^[a-zA-Z0-9\s@!#.,\-\+]+$/',
        ]);
        

        // Retrieve the user's course registration record
        $update_user_feedback = Courseregistrations::where('user_id', auth()->user()->id)->firstOrFail();

        // Extract and store only the required feedback data
        $feedbackData = [];
        foreach ($request->Feedback as $key => $feedback) {
            $questionNumber = substr($key, 1); // Extract question number from key
            
            // Construct the key for feedQX dynamically
            $feedQKey = 'feedQ'.$questionNumber;

            // Extract data for the current question
            $feedbackData[] = [
                'question' => $feedback['quest'],
                'answer_q'.$questionNumber => $feedback[$feedQKey],
            ];
        }

        //  // If the user selected "Yes" for recommending the platform, include additional counselor information
        // if ($request->input('Feedback.q5.feedQ5') === 'Yes') {
        //     $counselorInfo = [
        //         'counselorName' => $request->input('Feedback.q5.counselorName'),
        //         'phoneNumber' => $request->input('Feedback.q5.phoneNumber'),
        //         'email' => $request->input('Feedback.q5.email'),
        //         'doctorName' => $request->input('Feedback.q5.doctorName'),
        //     ];
        //     $feedbackData[] = [
        //         'question' => 'Additional Information for Recommending Counselor',
        //         'counselor_info' => $counselorInfo,
        //     ];
        // }


        // Encode the extracted feedback data as JSON
        $jsonFeedbackData = json_encode($feedbackData);

        // Save the encoded feedback data
        $update_user_feedback->feedback = $jsonFeedbackData;
        $update_user_feedback->save();
        
        // Redirect back with success or error message
        return redirect()->back()->with($update_user_feedback ? 'success' : 'danger', $update_user_feedback ? "Course feedback updated successfully." : "Failed to update course feedback. Please try again later.");
    }



    public function appointment_booked(){
        $registration_detail = Registrations::where('user_id', auth()->user()->id)->first();

        return view('campexecutive.appointment_booked',['registration_detail' => $registration_detail]); 
    }
    

    public function register_appointment(Request $request)
    {

        $request -> validate([
            'course_registrations_id' => 'required|exists:courseregistrations,id',
            'appointment_date' => 'required|date',
            'time_slot' => ['required', 'regex:/^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/'],
        ]);


        try {
            // Find the course registration details
            $registeredcourse_details = Courseregistrations::findOrFail($request->course_registrations_id);

            // // Find the appointment details
            // $appointment_details = Appointments::where('project_manager_id', $registeredcourse_details->by_prj_manager_id)->firstOrFail();

            // Start a transaction
            DB::beginTransaction();

            // Create a new registration record
            $register_user_appointment = new Registrations();
            $register_user_appointment->user_id = auth()->user()->id;
            $register_user_appointment->course_id = $registeredcourse_details->course_id;
            $register_user_appointment->project_manager_id = $registeredcourse_details->by_prj_manager_id;
            $register_user_appointment->course_registrations_id = $request->course_registrations_id;
            $register_user_appointment->appointment_date = $request->appointment_date;
            $register_user_appointment->appointment_time = $request->time_slot;
            $register_user_appointment->save();

            // Update the appointment booked status
            $registeredcourse_details->appointment_booked_status = 'yes';
            $registeredcourse_details->save();

            // Commit the transaction
            DB::commit();

            return redirect()->back()->with('success', "Appointment booked successfully");
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();
            return redirect()->back()->with('fail', "Sorry, appointment could not be booked. Please try again later.");
        }
    }

    public function report_list(){
        $quizmasterlist = Courseregistrations::all();
        return view('projectleader.master_report',['quizmasterlist' => $quizmasterlist]); 
    }

    public function downloadReportCsv_old()
        {
            // Get all data
            $registrations = DB::table('courseregistrations')
                ->join('users', 'courseregistrations.user_id', '=', 'users.id')
                ->join('courses', 'courseregistrations.course_id', '=', 'courses.id')
                ->select(
                    'courseregistrations.*',
                    'users.name as user_name',
                    'users.email',
                    'users.phone',
                    'users.city',
                    'courses.course_name'
                )
                ->get();

            // Headers
            $filename = 'quiz_master_report_' . now()->format('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            // Stream the CSV
            $callback = function () use ($registrations) {
                $file = fopen('php://output', 'w');

                // CSV heading
                fputcsv($file, [
                    'Registration ID',
                    'User Name',
                    'Email',
                    'Phone',
                    'City',
                    'Course Title',
                    'Module Number',
                    'Question Number',
                    'Question',
                    'User Selected Option',
                    'Correct Answer',
                    'Correct Answer Explanation',
                    'Course Status',
                    'Registered On',
                ]);

                foreach ($registrations as $reg) {
                    for ($i = 1; $i <= 15; $i++) {
                        $moduleKey = "module_{$i}_quiz";
                        if (!empty($reg->$moduleKey)) {
                            $quizData = json_decode($reg->$moduleKey, true);

                            if (!empty($quizData['mcqs']) && is_array($quizData['mcqs'])) {
                                foreach ($quizData['mcqs'] as $qNumber => $mcq) {
                                    fputcsv($file, [
                                        $reg->id,
                                        $reg->user_name,
                                        $reg->email,
                                        $reg->phone,
                                        $reg->city,
                                        $reg->course_name,
                                        "Module $i",
                                        "Question $qNumber",
                                        $mcq['question'] ?? '',
                                        $mcq['options'][$mcq['user_selected_option']] ?? '',
                                        $mcq['options'][$mcq['correct_answer']] ?? '',
                                        $mcq['correct_answer_explanation'] ?? '',
                                        $reg->course_status,
                                        $reg->created_at,
                                    ]);
                                }
                            }
                        }
                    }
                }

                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
    }

    public function downloadReportCsv_oldV1()
    {
        // Get all course registrations with related user and course info
        $registrations = DB::table('courseregistrations')
            ->join('users', 'courseregistrations.user_id', '=', 'users.id')
            ->join('courses', 'courseregistrations.course_id', '=', 'courses.id')
            ->select(
                'courseregistrations.*',
                'users.name as user_name',
                'users.email',
                'users.phone',
                'users.city',
                'courses.course_name'
            )
            ->get();

        // Prepare dynamic headers
        $moduleHeaders = [];
        $maxQuestionsPerModule = [];

        // First pass: detect max number of questions per module
        foreach ($registrations as $reg) {
            for ($i = 1; $i <= 15; $i++) {
                $moduleKey = "module_{$i}_quiz";
                if (!empty($reg->$moduleKey)) {
                    $quizData = json_decode($reg->$moduleKey, true);
                    $mcqs = $quizData['mcqs'] ?? [];
                    $count = count($mcqs);
                    if (!isset($maxQuestionsPerModule[$i]) || $count > $maxQuestionsPerModule[$i]) {
                        $maxQuestionsPerModule[$i] = $count;
                    }
                }
            }
        }

        // Build module headers
        foreach ($maxQuestionsPerModule as $module => $qCount) {
            for ($q = 1; $q <= $qCount; $q++) {
                $moduleHeaders[] = "Module $module - Q$q";
            }
        }

        // Final CSV headers
        $headers = array_merge([
            'Registration ID',
            'User Name',
            'Email',
            'Phone',
            'City',
            'Course Title',
            'Course Status',
            'Registered On',
        ], $moduleHeaders);

        // File name
        $filename = 'quiz_master_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        // Streaming response
        $callback = function () use ($registrations, $headers, $maxQuestionsPerModule) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);

            foreach ($registrations as $reg) {
                $row = [
                    $reg->id,
                    $reg->user_name,
                    $reg->email,
                    $reg->phone,
                    $reg->city,
                    $reg->course_name,
                    $reg->course_status,
                    $reg->created_at,
                ];

                // Add all quiz answers per module
                foreach ($maxQuestionsPerModule as $module => $qCount) {
                    $moduleKey = "module_{$module}_quiz";
                    $answers = [];

                    if (!empty($reg->$moduleKey)) {
                        $quizData = json_decode($reg->$moduleKey, true);
                        $mcqs = $quizData['mcqs'] ?? [];

                        foreach ($mcqs as $index => $mcq) {
                            $question = $mcq['question'] ?? '';
                            $userOptIndex = $mcq['user_selected_option'] ?? '';
                            $correctOptIndex = $mcq['correct_answer'] ?? '';
                            $options = $mcq['options'] ?? [];

                            $userAnswer = $options[$userOptIndex] ?? '';
                            $correctAnswer = $options[$correctOptIndex] ?? '';

                            $answers[] = "Q: $question | Selected: $userAnswer | Correct: $correctAnswer";
                        }
                    }

                    // Pad with empty values if questions are fewer
                    for ($i = 0; $i < $qCount; $i++) {
                        $row[] = $answers[$i] ?? '';
                    }
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function downloadReportCsv_oldV2()
    {
        // Get data with user and course details
        $registrations = DB::table('courseregistrations')
            ->join('users', 'courseregistrations.user_id', '=', 'users.id')
            ->join('courses', 'courseregistrations.course_id', '=', 'courses.id')
            ->select(
                'courseregistrations.*',
                'users.name as user_name',
                'users.email',
                'users.phone',
                'users.city',
                'courses.course_name'
            )
            ->get();

        // Headers
        $filename = 'quiz_master_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // Stream CSV response
        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');

            // Build dynamic CSV header
            $staticHeaders = [
                'Registration ID', 'User Name', 'Email', 'Phone', 'City', 'Course Title', 'Course Status', 'Registered On',
            ];

            $moduleHeaders = [];
            for ($i = 1; $i <= 15; $i++) {
                $module = "module_{$i}_quiz";
                $moduleHeaders[] = "Module {$i} - Question";
                $moduleHeaders[] = "Module {$i} - Correct Answer";
                $moduleHeaders[] = "Module {$i} - User Selected Answer";
            }
            $staticHeaders[] = "Total Correct Answers";

            // Final header
            fputcsv($file, array_merge($staticHeaders, $moduleHeaders));

            // Loop each registration
            foreach ($registrations as $registration) {
               $row = [
                        $registration->id,
                        $registration->user_name,
                        $registration->email,
                        $registration->phone,
                        $registration->city,
                        $registration->course_name,
                        $registration->course_status,
                        $registration->created_at,
                    ];

                    $totalCorrect = 0;

                    $moduleColumns = [];

                    for ($i = 1; $i <= 15; $i++) {
                        $column = "module_{$i}_quiz";
                        if (!empty($registration->$column)) {
                            $quizData = json_decode($registration->$column, true);
                            $mcqs = $quizData['mcqs'] ?? [];

                            $questions = [];
                            $correctAnswers = [];
                            $userAnswers = [];

                            foreach ($mcqs as $q) {
                                $questions[] = $q['question'];
                                $correct = $q['options'][$q['correct_answer']] ?? '';
                                $selected = $q['options'][$q['user_selected_option']] ?? '';

                                $correctAnswers[] = $correct;
                                $userAnswers[] = $selected;

                                if ($q['user_selected_option'] === $q['correct_answer']) {
                                    $totalCorrect++;
                                }
                            }

                            $moduleColumns[] = implode(" | ", $questions);
                            $moduleColumns[] = implode(" | ", $correctAnswers);
                            $moduleColumns[] = implode(" | ", $userAnswers);
                        } else {
                            $moduleColumns[] = '';
                            $moduleColumns[] = '';
                            $moduleColumns[] = '';
                        }
                    }

                    // Append total correct at right position
                    $row[] = $totalCorrect;

                    // Then append module data
                    $row = array_merge($row, $moduleColumns);

                    fputcsv($file, $row);

            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadReportCsv()
    {
        $registrations = DB::table('courseregistrations')
            ->join('users', 'courseregistrations.user_id', '=', 'users.id')
            ->join('courses', 'courseregistrations.course_id', '=', 'courses.id')
            ->select(
                'courseregistrations.*',
                'users.name as user_name',
                'users.email',
                'users.phone',
                'users.city',
                'courses.course_name'
            )
            ->get();

        $filename = 'quiz_master_report_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');

            // Header row
            $staticHeaders = [
                'Registration ID', 'User Name', 'Email', 'Phone', 'City', 'Course Title', 'Course Status', 'Registered On'
            ];

            $moduleHeaders = [];
            for ($i = 1; $i <= 15; $i++) {
                $moduleHeaders[] = "Module {$i} - Question(s)";
                $moduleHeaders[] = "Module {$i} - Correct Answer(s)";
                $moduleHeaders[] = "Module {$i} - User Selected Answer(s)";
            }

            $finalHeader = array_merge($staticHeaders, $moduleHeaders, ['Total Correct Answers']);
            fputcsv($file, $finalHeader);

            foreach ($registrations as $registration) {
                $row = [
                    $registration->id,
                    $registration->user_name,
                    $registration->email,
                    $registration->phone,
                    $registration->city,
                    $registration->course_name,
                    $registration->course_status,
                    $registration->created_at,
                ];

                $moduleColumns = [];
                $totalCorrect = 0;


                for ($i = 1; $i <= 15; $i++) {
                    $column = "module_{$i}_quiz";

                    if (!empty($registration->$column)) {
                        $quizData = json_decode($registration->$column, true);
                        $mcqs = $quizData['mcqs'] ?? [];

                        $questions = [];
                        $correctAnswers = [];
                        $userAnswers = [];

                        foreach ($mcqs as $q) {
                            $question = $q['question'] ?? '';
                            $options = $q['options'] ?? [];

                            // Handle correct answer
                            $correctIndex = isset($q['correct_answer']) ? ((int)$q['correct_answer'] - 1) : -1;
                            $correctAnswer = isset($options[$correctIndex]) ? $options[$correctIndex] : 'Not Answered';

                            // Handle user-selected answer
                            $userSelectedIndex = isset($q['user_selected_option']) ? ((int)$q['user_selected_option'] - 1) : -1;
                            $userSelectedAnswer = isset($options[$userSelectedIndex]) ? $options[$userSelectedIndex] : 'Not Answered';

                            // Store values
                            $questions[] = $question;
                            $correctAnswers[] = $correctAnswer;
                            $userAnswers[] = $userSelectedAnswer;

                            // Count correct answers
                            if ($correctIndex === $userSelectedIndex && $correctIndex >= 0) {
                                $totalCorrect++;
                            }
                        }


                        $moduleColumns[] = implode(" | ", $questions);
                        $moduleColumns[] = implode(" | ", $correctAnswers);
                        $moduleColumns[] = implode(" | ", $userAnswers);
                    } else {
                        $moduleColumns[] = '';
                        $moduleColumns[] = '';
                        $moduleColumns[] = '';
                    }
                }

                // Add module answers and total correct answers to the row
                $row = array_merge($row, $moduleColumns, [$totalCorrect]);

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }



    
}
