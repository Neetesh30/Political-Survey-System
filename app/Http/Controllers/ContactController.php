<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;

use Illuminate\Support\Facades\Http;

use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User; 




class ContactController extends Controller
{
    public function sendMessage(Request $request)
{
    
     // Retrieve the user by mobile number
    $user = User::where('phone', $request->mobile)->first();

     
    $apiKey = env('TEXTLOCAL_API_KEY');
    $sender = 'SARTHi'; // Replace with your sender name
    $numbers = $request->mobile; // Assuming phone number is submitted via form
    $otp = rand(100000, 999999); // Generate a random 6-digit OTP
    $templateId = 1707164942226122560; // Replace with the ID of your Textlocal template

    // Store the OTP in the session
    $request->session()->put('otp', $otp);

    // Construct the message with placeholders
    $message = "Dear $user->name, OTP for confirming your consent is $otp, thank you for your participation. Regards, Saarathi Healthcare Pvt Ltd";

    $client = new Client();
    
    $response = $client->post('https://api.textlocal.in/send/', [
        'form_params' => [
            'apiKey' => $apiKey,
            'numbers' => $numbers,
            'template' => $templateId,
            'message' => $message, // Pass the modified message
            'sender' => $sender
        ]
    ]);


     if ($user) {
         // Send email for otp
         $email = $user->email;

         Mail::to($email)->send(new SendOtpMail($otp)); // Assuming you have an OtpEmail Mailable
        
    }


    
    // Parse the response
    $body = $response->getBody();
    $statusCode = $response->getStatusCode();
    
    if ($statusCode == 200) {
        $responseData = json_decode($body, true);
        // Here you can handle the response data as needed


        return response()->json(['success' => true, 'message' => "OTP sent successfully : $otp", 'response' => $responseData]);
    } else {
        // If there's an error with the API request
        return response()->json(['success' => false, 'message' => 'Failed to send OTP', 'response' => $body]);
    }
}


public function testCharityAPI()
    {
        // Define your Charity API parameters
        $authKey = "CHARITABL2023";
        $mobileNumber = "919768300737"; // Replace with the mobile number of the charity organization
        $message = "Test message from Charity API"; // Define the message to be sent

        // Send a test message using the Charity API
        $response = Http::post("https://api4ws.com/sendMessage.php?AUTH_KEY=CHARITABL2023&instance_id=552088&message=$message&phone=919768300737");

        // Check if the request was successful
        if ($response->successful()) {
            // Log success message
            return response()->json(['message' => 'Message sent successfully to charity organization.']);
        } else {
            // Log error message
            $errorMessage = $response->body();
            return response()->json(['error' => 'Error sending message to charity organization.']);
        }
    }
    
    
}
