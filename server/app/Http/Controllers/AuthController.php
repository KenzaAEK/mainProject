<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use HttpResponses; 

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        
    }






    public function logout(Request $request)
    {
        return response()->json('this is a logout test');
    }

}
