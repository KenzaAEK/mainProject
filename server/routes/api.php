<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ActiviteController;
use App\Http\Controllers\Api\AdministrateurController;
use App\Http\Controllers\Api\DemandeInscriptionController;
use App\Http\Controllers\Api\DevisController;
use App\Http\Controllers\Api\EnfantController;
use App\Http\Controllers\Api\TypeActiviteController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);






Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);
    Route::apiResource('activites', ActiviteController::class);
    Route::get('/users', [AuthController::class, 'index']);
    // for admins only and authenticated  
    //add middlewear check role 

    Route::apiResource('activites', ActiviteController::class);
    Route::apiResource('type-activites', TypeActiviteController::class);
    Route::post('/admins/approve-demande/{id}', [AdministrateurController::class, 'approveDemande']);
    Route::post('/admin/reject-demande/{id}', [AdministrateurController::class, 'rejectDemande']);







    //add middlewear check role 
    // for parents only and authenticated
    Route::apiResource('enfants', EnfantController::class);
    Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class); 
    Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
    Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);
    



    //add middlewear check role 
    // for animators only and authenticated 
    
    





});



