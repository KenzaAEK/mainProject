<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\Auth\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use App\Models\Tuteur;


class AuthController extends Controller
{
    use HttpResponses;
   
    public function register(StoreUserRequest $request)   
    {
        $request->validated($request->all());


        $existingUser = User::where('email', $request->email)->first();
        
        if ($existingUser) {
            // User already exists
            return $this->error('', 'Un utilisateur avec cet email existe déjà. :(', 409); // 409 Conflict
        }

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'tel' => $request->tel,
            'password' => Hash::make($request->password),    //or the  bcrypt($request->password)
            'role' => "1", // 1 = parent , 2 = admin , 3 = animateur
        ]);
        Tuteur::create(['idUser' => $user->idUser]);
        $token = $user->createToken('token-name')->plainTextToken;

        //$token = $user->createToken('token-name', [], now()->addMinutes(30))->plainTextToken;  // automated in the config/sanctum.php file


        return $this->success([
            'user' => $user,
            'token' =>$token,
        ],'Inscription réussie. :)');
        
    }
    public function login(LoginUserRequest $request) 
    {
        $request->validated($request->all());
        if(!Auth::attempt($request->only(['email','password'])))
        {
            return $this->error('','Les informations d\'identification ne correspondent pas. :(',401);
        }

        
        $user = User::where('email',$request->email)->first();
        //$user = Auth::user();

        // if($user){
        //     $validTokens = $user->tokens()
        //     ->where('expires_at', '>', now())
        //     ->count();
        //     if ($validTokens > 0) {
        //         return $this->error('','already logged in',409);
        //     }
        // }

        // simply i can change the config/sanctum.php file   change the expiration time bla had za3ter kameel
        $token = $user->createToken('token-name')->plainTextToken;
        // $personalAccessToken = PersonalAccessToken::findToken($token);
        // $personalAccessToken->expires_at = Carbon::now()->addMinutes(30);  //or  simply change the config/sanctum.php file                                                          
        // $personalAccessToken->save();



        //delete the expired tokens when a user logs in or try to login but i have to change the place of this line of code 
        // or simply i can implement a schedule to delete the expired tokens console/kernel.php  $schedule->command('sanctum:prune-expired --hours=24')->daily();
        // PersonalAccessToken::where('expires_at', '<', now())->delete();

        return $this->success([
            'user' => $user,
            'token' => $token,
        ],'Connecté avec succès. :)');
    }
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->success([
            
        ],'Déconnecté avec succès et jeton supprimé. :)',);
    }

    public function refreshToken(Request $request) // tested and working 
    {
        // Get the authenticated user
        $user = auth()->user();

        // Delete all existing tokens (force the user to login again on all devices)
        //$user->tokens()->delete();
        // delete only the current token , (the current device)
        auth()->user()->currentAccessToken()->delete();
        // Create a new token
        $token = $user->createToken('token-name')->plainTextToken;

        // Set an expiry time
        //or  simply change the config/sanctum.php file 
        // $personalAccessToken = PersonalAccessToken::findToken($token);
        // $personalAccessToken->expires_at = Carbon::now()->addMinutes(30);
        // $personalAccessToken->save();

        // Return the new token
        return $this->success([
            'token' => $token
        ], 'Jeton rafraîchi avec succès. :)');
    }

}
