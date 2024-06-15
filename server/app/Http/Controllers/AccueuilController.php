<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class AccueuilController extends Controller
{
    use HttpResponses;

    public function index()
    {

        
        //    return auth::user();
        return "bonjour le monde";

        
    }
}
