<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class PersonalDetailsController extends Controller
{
    public function profileupdate(Request  $request){
        // dd($request);
        $request -> validate([
            'name' => "required|regex:/^[a-zA-Z ]*$/|min:4|max:50",
            // 'phone' => ['required', 'numeric','digits_between:10,10','regex:/^[0-9]+$/',],
            'gender' => [
                'required',
                Rule::in(['male','female']),
            ],
            'dateofbirth' => "required|date|date_format:d-m-Y"
        ]);


        $current_patientid = auth()->user()->id;

        $update_patient_basicinformation =  User::find($current_patientid);

        $update_patient_basicinformation -> name =  $request->name;
        // $update_patient_basicinformation -> phone =  $request->phone;
        $update_patient_basicinformation -> gender =  $request->gender;
        $update_patient_basicinformation -> dateofbirth =  $request->dateofbirth;
        $update_patient_basicinformation -> address =  $request->address;
        $update_patient_basicinformation -> city =  $request->city;
        $update_patient_basicinformation -> state =  $request->state;
        $update_patient_basicinformation -> zipcode =  $request->zipcode;
        $update_patient_basicinformation -> country =  $request->country;
        
        $update_patient_basicinformation -> save();
        
        if($update_patient_basicinformation){
            return  redirect()->back()->with('success','User Basic Information uploaded successfully');
        }else{
            return  redirect()->back()->with('fail','Sorry , User Basic Information not uploaded, try again later');
        }
        
    
    }


    public function imageupdate(Request  $request){
        $request -> validate([
            'image' => 'required|image|mimes:jpg,png|max:512',
        ],[
            'image.required' => 'Image Is required.',
        ]);

        //dd($request);

        $request ->input();

        $imageName = 'user_id_'.auth()->user()->id."_".time().'.'.$request->file('image')->extension();  

        $request->file('image')->move(public_path('/assets/img/profile'), $imageName);
        
        $update_admin_image =  User::find(auth()->user()->id);
        
        $update_admin_image -> imagepath =  $imageName;
        
        $update_admin_image -> save();
        
        if($update_admin_image){
            return  redirect()->back()->with('success','image uploaded successfully');
        }else{
            return  redirect()->back()->with('fail','image failed, try again later');
        }
        
    }


    public function changeprofileoldnewpassword(Request  $request){
        // dd($request);
        $request -> validate([
            'oldpassword' => 'required',
            'newpassword' => 'required|alpha_dash|min:4|max:10',
            'cpassword' => 'required|alpha_dash|same:newpassword|min:4|max:10',
        ],[
            'phoneno.required' => 'The Mobile Number is required.',
            'cpassword.required' => 'Confirm Password Field is required.',
            'cpassword.same' => 'Confirm Password should be same as New Password.',
        ]);
        
        $admindata = User::select('password','id')->where('id', auth()->user()->id)->get();
        
        foreach ($admindata as $users) {
            $users->password;
        }
        
         $updtadminoldpassword = $request->oldpassword;
         $oldpassword = $users->password;
        
        //dd($request);
        
        if (Hash::check($updtadminoldpassword, $oldpassword)) {
            $updtadminid = auth()->user()->id;
            $updtadminnewpassword = $request->newpassword;
            
            $update_admin_password =  User::find($updtadminid);

            $update_admin_password -> password =  Hash::make($updtadminnewpassword);
            
            $update_admin_password -> save();
            
            if($update_admin_password){

                auth()->logout();
                return  redirect()->route('login')->with('success','New password changed, login again with new password');

            }else{

                return  redirect()->back()->with('fail','Sorry , new password is not saved  , try again later');
            }
            
        }else{
            
            return  redirect()->back()->with('fail','Old password does not match , try again later');
            
        }
        
    }

    public function user_intro_status(Request  $request){
        
        $current_userid = auth()->user()->id;

        $update_user_intro =  User::find($current_userid);

        $update_user_intro->user_intro = 1;
        
        $update_user_intro -> save();
        
        if($update_user_intro){
            return  redirect()->back()->with('success','User Information updated successfully');
        }else{
            return  redirect()->back()->with('fail','Sorry , User Basic Information not updated, try again later');
        }
        
    
    }

    
    

}
