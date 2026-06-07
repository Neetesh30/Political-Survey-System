<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
 
class OTPLoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
{
    if (auth()->check()) {
        $user_role = auth()->user()->role;
        
        $user_logged=Auth::user();

        if ($user_logged->is_logged_in) {
            Auth::logout();
            return redirect()->back()->with('danger', 'User is already logged in from another device.');
        }
        
        $user_logged->is_logged_in = true; // Update is_logged_in to true
        $user_logged->save();
        
        
        if ($user_role === '5') {
            $this->redirectTo = '/user';
        } elseif ($user_role === '2') {
            $this->redirectTo = '/prjmngrlist';
        }
    }
    return $this->redirectTo ?? RouteServiceProvider::HOME;
}

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the mobile OTP login form.
     *
     * @return \Illuminate\View\View
     */
    public function showMobileLoginForm()
    {
        return view('auth.login-mobile');
    }

    /**
     * Handle a mobile OTP login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric|digits:10',
            'otp' => 'required|numeric|digits:6',
        ]);

        $mobile = $request->input('phone');
        $otp = $request->input('otp');

        
        // Validate OTP
        if ($this->validateOTP($mobile, $otp)) {
            // OTP is valid, find and log in the user
            $user = User::where('phone', $mobile)->first();
            if ($user) {
                // Check user role and redirect accordingly
                if ($user->role === 5) {
                    Auth::login($user);
                    return redirect()->route('user.home');
                } elseif ($user->role === 2) {
                    Auth::login($user);
                    return redirect()->route('projectleader.home');
                }
            } else {
                return redirect()->back()->withErrors(['phone' => 'User not found'])->withInput();
            }
        } else {
            return redirect()->back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
        }
    }


    /**
     * Logout the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Validate the OTP entered by the user.
     *
     * @param string $mobile
     * @param string $otp
     * @return bool
     */
    protected function validateOTP($mobile, $otp)
    {
        // This is a simple example, you should implement your OTP validation logic here
        // $storedOTP = Session::get('otp' . $mobile);
        $storedOTP = (string)session('otp');
        // dd($storedOTP,$otp);
        return $storedOTP === $otp;
    }

    /**
     * Find a user based on mobile number.
     *
     * @param string $mobile
     * @return \App\Models\User|null
     */
    protected function findUserByMobile($mobile)
    {
        // In this example, we'll find the user based on the mobile number
        return User::where('phone', $mobile)->first();
    }
}
