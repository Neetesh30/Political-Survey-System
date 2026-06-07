<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\PersonalDetailsController;
use App\Http\Controllers\AdminMainController;
use App\Http\Controllers\ContactController;
// use App\Http\Controllers\Auth\OTPLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SurveyController;


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
    return view('auth.login');
});


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
    
    // Route::GET('/',[AdminMainController::class,'project_mngr_show_dashboard_data'])->name('home');

    Route::get('/', [SurveyController::class, 'results']);
    Route::get('survey-export', [SurveyController::class, 'exportCsv']);
   
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
    // For Export CSV reports
    // Route::get('/masterreport', function () { return view('projectleader.master_report');})->name('masterreport');
    Route::get('/masterreport', [AdminMainController::class,'report_list'])->name('masterreport');
    Route::get('/report/download-csv', [AdminMainController::class, 'downloadReportCsv'])->name('report.download.csv');
    // Route::post('/report', [VideoController::class, 'export'])->name('report');

});

// Survey for Elections

Route::post('/survey-submit', [SurveyController::class, 'store'])->name('surveysubmit');

Route::post('/survey-user-details', [SurveyController::class, 'updateUserDetails'])->name('surveyuserdetails');

Route::get('/survey-count', function () {
    $actual = \App\Models\Survey::count();
    $base   = 5249;

    return response()->json([
        'count' => $actual + $base,
        'actual' => $actual // optional (for internal use)
    ]);
});



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
