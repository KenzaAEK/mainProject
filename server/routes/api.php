<?php

use App\Http\Controllers\AdministrateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ActiviteController;
use App\Http\Controllers\Api\OffreController;
use App\Http\Controllers\Api\DemandeInscriptionController;
use App\Http\Controllers\Api\EnfantController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\Api\GroupeController;
use App\Http\Controllers\api\password\UpdatePasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Symfony\Component\HttpKernel\Profiler\Profile;


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/password-reset',[AuthController::class, 'passwordReset']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);


    Route::post('/upload-image', [ProfileController::class, 'uploadImage']);
    Route::post('/profile', [ProfileController::class, 'profile']);
    Route::post('/udpdate-profile', [ProfileController::class, 'updateProfile']);

    Route::post('/password/update', [ UpdatePasswordController::class, 'UpdatePassword']);
    //Route::post('/password/reset', [ResetController::class, 'ResetPassword']);

    //========================================= ADMIN API =====================================================
    //add middlewear check role 


    Route::apiResource('activites', ActiviteController::class);
    Route::post('/offres',[OffreController::class,'store']);
    Route::get('/offres/{offres}',[OffreController::class,'show']);
    Route::put('/offres/{offres}',[OffreController::class,'customUpdate']);
    Route::post('/offres/{offres}/{activites}',[OffreController::class,'destroy']);
    Route::get('/animateurs', [GroupeController::class, 'index']);
    Route::apiResource('activites', ActiviteController::class);






    //========================================= PARENT API =====================================================

    //add middlewear check role 

    //Manage enfant
    Route::apiResource('parent/enfants', EnfantController::class);
    // Manage demande-inscriptions
    Route::apiResource('parent/demande-Inscriptions', DemandeInscriptionController ::class); 
    // Accept or reject devis
    Route::post('parent/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
    Route::post('parent/devis/{id}/reject', [DevisController::class, 'rejectDevis']);
    // Manage notifications

    // Route::get('parent/notifications', [NotificationController::class, 'index']);
    // Route::get('parent/notifications/{notification}', [NotificationController::class, 'show']);
    // Route::put('parent/notifications/{notification}/markAsRead', [NotificationController::class, 'markAsRead']);

    //OFFRES
    Route::get('parent/offres', [OffreController::class, 'index']);
    Route::get('parent/offres/{offre}', [OffreController::class, 'show']);
    Route::get('parent/offres/{offre}/details', [OffreController::class, 'showDetails']);

    //========================================= ANIMATEUR API =====================================================

    //add middlewear check role 
    
    





});



