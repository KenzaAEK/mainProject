<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
route::post('/login', [AuthController::class, 'login']);


route::post('/register', [AuthController::class, 'register']);

//add a middleware here for the logout method
route::post('/logout', [AuthController::class, 'logout']);