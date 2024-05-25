<?php

namespace App\Http\Controllers\Api\Password;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        try {
            $emailData = ['token' => $token, 'email' => $request->email];

            Mail::send('emails.forgot-password', $emailData, function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Réinitialisation du mot de passe');
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'L\'envoi de l\'e-mail a échoué.'], 500);
        }

        return response()->json(['message' => 'Lien de réinitialisation envoyé à votre adresse e-mail.'], 200);
    }

    public function resetPassword(Request $request, $token)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Jeton ou adresse e-mail invalide.'], 400);
        }

        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Le mot de passe a été réinitialisé.'], 200);
    }
}