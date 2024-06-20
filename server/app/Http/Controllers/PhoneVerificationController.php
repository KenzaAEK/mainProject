<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PhoneVerification;
use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Carbon\Carbon;

class PhoneVerificationController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate(['phone_number' => 'required']);

        $basic  = new Basic(env('VONAGE_KEY'), env('VONAGE_SECRET'));
        $client = new Client($basic);

        $verification_code = rand(100000, 999999); // Generate a random verification code

        $client->message()->send([
            'to' => $request->phone_number,
            'from' => env('VONAGE_SMS_FROM'),
            'text' => "Your verification code is: {$verification_code}"
        ]);

        PhoneVerification::create([
            'phone_number' => $request->phone_number,
            'verification_code' => $verification_code,
            'expires_at' => Carbon::now()->addMinutes(10) // Code expires in 10 minutes
        ]);

        return response()->json(['message' => 'Verification code sent.']);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'verification_code' => 'required|numeric',
        ]);

        $verification = PhoneVerification::where('phone_number', $request->phone_number)
                                         ->where('verification_code', $request->verification_code)
                                         ->where('expires_at', '>', Carbon::now())
                                         ->first();

        if ($verification) {
            return response()->json(['message' => 'Phone verified successfully.']);
        } else {
            return response()->json(['message' => 'Invalid or expired verification code.'], 422);
        }
    }
}

