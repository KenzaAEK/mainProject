<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;


class AuthController extends Controller
{
    use HttpResponses;
   
    public function register(StoreUserRequest $request)   // workingggg and already testeeed in postman
    {
        $request->validated($request->all());
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password) //or the  bcrypt($request->password)
        ]);

        $token = $user->createToken('token-name', [], now()->addMinutes(30))->plainTextToken;  // experation tiiiiiiimeeee of the token*****************


        return $this->success([
            'user' => $user,
            'token' =>$token
        ]);
    }



    public function login(LoginUserRequest $request) // workingggg and already testeeed in postman
    {
        $request->validated($request->all());
        if(!Auth::attempt($request->only(['email','password'])))
        {
            return $this->error('','credentials do not match',401);
        }

        
        $user = User::where('email',$request->email)->first();
        
        if($user){
            $validTokens = $user->tokens()
            ->where('expires_at', '>', now())
            ->count();
            if ($validTokens > 0) {
                return $this->error('','already logged in',409);
            }
        }

        
        // ghadi nzid hna l expiration DYAL  token besh n implementer l refresh token et khsni ndwi m3a lfront besh y regerererwha 9bel matexpira

        // simply i can change the config/sanctum.php file   change the expiration time bla had za3ter kameel
        $token = $user->createToken('token-name')->plainTextToken;
        $personalAccessToken = PersonalAccessToken::findToken($token);
        $personalAccessToken->expires_at = Carbon::now()->addMinutes(30);// i can change the time here ask karima or discuss with the team
        $personalAccessToken->save();



        //delete the expired tokens when a user logs in or try to login but i have to change the place of this line of code 
        // or simply i can implement a schedule to delete the expired tokens console/kernel.php  $schedule->command('sanctum:prune-expired --hours=24')->daily();
        PersonalAccessToken::where('expires_at', '<', now())->delete();

        return $this->success([
            'user' => $user,
            'token' => $token
        ]);
    }










    public function logout() // // workingggg and already testeeed in postman
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->success([
            'message' => 'logged out successfully and token deleted'
        ]);
    }

    public function refreshToken(Request $request) // not tested yet
    {
        // Get the authenticated user
        $user = auth()->user();

        // Delete all existing tokens
        $user->tokens()->delete();

        // Create a new token
        $token = $user->createToken('token-name')->plainTextToken;

        // Set an expiry time
        //or  simply change the config/sanctum.php file 
        $personalAccessToken = PersonalAccessToken::findToken($token);
        $personalAccessToken->expires_at = Carbon::now()->addMinutes(30);   // swel les tuteurs et team 
        $personalAccessToken->save();

        // Return the new token
        return $this->success([
            'token' => $token
        ], 'Token successfully refreshed');
    }

}
