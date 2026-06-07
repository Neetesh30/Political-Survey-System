<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\PersonalDetailsController;
use App\Http\Controllers\AdminMainController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\OTPLoginController;
use App\Http\Controllers\Auth\LoginController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/create-symlink', function () {
    try {
        Artisan::call('storage:link');
        return "Symbolic link created successfully!";
    } catch (\Exception $e) {
        return "Error creating the symbolic link: " . $e->getMessage();
    }
});


Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 2) {
            return redirect()->route('projectleader.home');
        } elseif (Auth::user()->role == 5) {
            return redirect()->route('user.home');
        }
    }
return view('auth.login');
});

Route::GET('/login/mobile', [OTPLoginController::class,'showMobileLoginForm'])->name('login.mobile');
Route::post('/moblogin', [OTPLoginController::class, 'login'])->name('moblogin');

Route::post('/sendotp', [ContactController::class, 'sendMessage'])->name('sendotp');
// Route::get('/', function () {
//     // return view('welcome');
//     return view('auth.login');
// });

Route::post('/newdoctorregistration', [AdminMainController::class, 'new_doctor_registration'])->name('newdoctorregistration');

Route::get('/counselloregister/{id}',[AdminMainController::class,'counsellor_register'])->name('counselloregister');
Route::post('/storecounsellor',[AdminMainController::class,'store_counsellor'])->name('storecounsellor');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    // Route::get('/', function () {
    //     return view('admin.home');
    // })->name('home');
    Route::GET('/',[AdminMainController::class,'admin_show_dashboard_data'])->name('home');


    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');

    Route::GET('/prjmngrlist',[AdminMainController::class,'getprjmngrlist'])->name('prjmngrlist');
    Route::post('/profileupdate',[PersonalDetailsController::class,'profileupdate'])->name('profileupdate');
    Route::post('/imageupdate',[PersonalDetailsController::class,'imageupdate'])->name('imageupdate');
    Route::post('/changeprofileoldnewpassword',[PersonalDetailsController::class,'changeprofileoldnewpassword'])->name('changeprofileoldnewpassword');
    
    // For New Doctors Registration
    Route::post('/changenewdoctorregstatus',[AdminMainController::class,'change_new_doctor_reg_status'])->name('changenewdoctorregstatus');
    Route::post('/doctorapprovestatus',[AdminMainController::class,'change_new_doctor_approve_status'])->name('doctorapprovestatus');
    Route::post('/doctorrejectstatus',[AdminMainController::class,'change_new_doctor_reject_status'])->name('doctorrejectstatus');

    // For Prj Manager
    Route::post('/addprjmanager',[AdminMainController::class,'createprjmanager'])->name('addprjmanager');
    Route::post('/editprjmanager',[AdminMainController::class,'editprjmanager'])->name('editprjmanager');
    Route::post('/deleteprjmanager',[AdminMainController::class,'deleteprjmanager'])->name('deleteprjmanager');

    // For Manage Status
    Route::POST('/editstatus',[AdminMainController::class,'manageuserstatus'])->name('editstatus');
    
    // Daily Quiz
    Route::GET('/dailyquiz',[AdminMainController::class,'daily_quiz'])->name('dailyquiz');

    Route::POST('/storedailyquiz',[AdminMainController::class,'store_daily_quiz'])->name('storedailyquiz');
    Route::put('/update-dailyquiz/{id}', [AdminMainController::class,'update_store_daily_quiz'])->name('update-dailyquiz');


});



Route::prefix('projectleader')->name('projectleader.')->middleware('projectleader')->group(function () {
    
    Route::GET('/',[AdminMainController::class,'project_mngr_show_dashboard_data'])->name('home');
    // Route::GET('/',[VideoController::class,'project_leader_show_all_booked_list'])->name('home');
   
    // For Profile
    Route::get('/profile', function () {
        return view('projectleader.profile');
    })->name('profile');

    Route::post('/profileupdate',[PersonalDetailsController::class,'profileupdate'])->name('profileupdate');
    Route::post('/imageupdate',[PersonalDetailsController::class,'imageupdate'])->name('imageupdate');
    Route::post('/changeprofileoldnewpassword',[PersonalDetailsController::class,'changeprofileoldnewpassword'])->name('changeprofileoldnewpassword');

    // For Manage Users
    Route::GET('/manageuserslist',[AdminMainController::class,'getmanageuserslist'])->name('manageuserslist');
    Route::post('/adduser',[AdminMainController::class,'createuser'])->name('adduser');
    Route::post('/importusers', [AdminMainController::class, 'importusers'])->name('importusers');
    Route::post('/edituser',[AdminMainController::class,'edituser'])->name('edituser');
    Route::post('/deleteuser',[AdminMainController::class,'deleteuser'])->name('deleteuser');
    
    // For Manage Status
    Route::POST('/editstatus',[AdminMainController::class,'manageuserstatus'])->name('editstatus');
    
    // For Quiz Resourcces 
    Route::get('/resources',[AdminMainController::class,'view_resources'])->name('resources');
    Route::post('/addresources',[AdminMainController::class,'add_resources'])->name('addresources');
    Route::post('/editresources',[AdminMainController::class,'edit_resources'])->name('editresources');
    Route::post('/deleteresources',[AdminMainController::class,'delete_resources'])->name('deleteresources');
    Route::post('/manageresourcestatus',[AdminMainController::class,'manageresourcestatus'])->name('manageresourcestatus');
    
    // For Quiz Creation 
    Route::get('/quizs',[AdminMainController::class,'view_quizs'])->name('quizs');
    Route::post('/addquiz',[AdminMainController::class,'add_quiz'])->name('addquiz');
    Route::post('/editquiz',[AdminMainController::class,'edit_quiz'])->name('editquiz');
    Route::post('/changeusercourse',[AdminMainController::class,'change_user_course'])->name('changeusercourse');
    Route::post('/deletequiz',[AdminMainController::class,'delete_quiz'])->name('deletequiz');
    Route::post('/managecourcestatus',[AdminMainController::class,'managecourcestatus'])->name('managecourcestatus');

    // For Appointment Sccheduling 
    Route::get('/appointment-scheduling',[AdminMainController::class,'appointment_scheduling'])->name('appointment-scheduling');
    
    Route::post('/store-appointment',[AdminMainController::class,'store_appointment'])->name('store-appointment');
    Route::put('/update-appointmentscheduling/{id}', [AdminMainController::class,'update_appointment_scheduling'])->name('update-appointmentscheduling');
    Route::post('/store-or-update-appointment/{id?}', [AdminMainController::class, 'createOrUpdate'])->name('store-or-update-appointment');

    Route::GET('/bookedappointmentuserslist',[AdminMainController::class,'booked_appointment_users_list'])->name('bookedappointmentuserslist');
    Route::post('/updatezoomdetailappointmentuserslist',[AdminMainController::class,'update_zoom_detail_appointment_users_list'])->name('updatezoomdetailappointmentuserslist');

    // For Feedback by users
    Route::get('/feedbacks',[AdminMainController::class,'feedbacks'])->name('feedbacks');
    



    // For Export CSV reports
    // Route::get('/masterreport', function () { return view('projectleader.master_report');})->name('masterreport');
    Route::get('/masterreport', [AdminMainController::class,'report_list'])->name('masterreport');
    Route::get('/report/download-csv', [AdminMainController::class, 'downloadReportCsv'])->name('report.download.csv');
    // Route::post('/report', [VideoController::class, 'export'])->name('report');

});


Route::prefix('user')->name('user.')->middleware('user')->group(function () {

    Route::GET('/',[AdminMainController::class,'user_dashboard'])->name('home');

    // For Profile
    Route::get('/profile', function () {
        return view('campexecutive.profile');
    })->name('profile');

    Route::post('/profileupdate',[PersonalDetailsController::class,'profileupdate'])->name('profileupdate');
    Route::post('/imageupdate',[PersonalDetailsController::class,'imageupdate'])->name('imageupdate');
    Route::post('/changeprofileoldnewpassword',[PersonalDetailsController::class,'changeprofileoldnewpassword'])->name('changeprofileoldnewpassword');
    Route::post('/userintrostatus',[PersonalDetailsController::class,'user_intro_status'])->name('userintrostatus');

    Route::get('/generate-image', [AdminMainController::class, 'generateImage'])->name('generate-image'); 


    // user courses exam
    Route::post('/submitcourseresult',[AdminMainController::class,'submit_course_result'])->name('submitcourseresult'); 
    Route::post('/submit_course_result_v2',[AdminMainController::class,'submit_course_result_v3'])->name('submit_course_result_v2'); 
    
    // user Feedback 
    Route::post('/submituserfeedback',[AdminMainController::class,'submit_user_feedback'])->name('submituserfeedback'); 

    // For Appointment Registration  
    Route::get('/appointmentbooked',[AdminMainController::class,'appointment_booked'])->name('appointmentbooked');

    Route::post('/registerappointment',[AdminMainController::class,'register_appointment'])->name('registerappointment');

    
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
