<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ActiviteController;
use App\Http\Controllers\Api\AdministrateurController;
use App\Http\Controllers\Api\DemandeInscriptionController;
use App\Http\Controllers\Api\DevisController;
use App\Http\Controllers\Api\EnfantController;
use App\Http\Controllers\Api\Password\PasswordResetController;
use App\Http\Controllers\Api\TypeActiviteController;

/*
╔==========================================================================╗
║                           All Users Routes                                   ║
╚==========================================================================╝
*/

Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']);

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])->name('password.reset');









Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);



Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);
    // Route::post('/upload-image', [ProfileController::class, 'uploadImage']);
    // Route::post('/profile', [ProfileController::class, 'profile']);
    // Route::post('/udpdate-profile', [ProfileController::class, 'updateProfile']); gate for animateur**** email 
    // Route::post('/password/update', [ UpdatePasswordController::class, 'UpdatePassword']);
    //Route::post('/password/reset', [ResetController::class, 'ResetPassword']); *********

    // Manage notifications
    // Route::get('/notifications', [NotificationController::class, 'index']);
    // Route::get('/notifications/{notification}', [NotificationController::class, 'show']);
    // Route::put('/notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead']);
    // Route::put('/notifications/{notification}/mark-as-unread', [NotificationController::class, 'markAsUnread']);
    // Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy']);
    // Route::put('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsread']);
    // Route::put('/notifications/mark-all-as-unread', [NotificationController::class, 'markAllAsUnread']);



/*
╔==========================================================================╗
║                           Admin Routes                                   ║
╚==========================================================================╝
*/
    Route::group(['middleware' => 'role:2', 'prefix' => 'admin'], function () {
  
        Route::apiResource('activites', ActiviteController::class);
        Route::apiResource('type-activites', TypeActiviteController::class);
        Route::post('/admins/approve-demande/{id}', [AdministrateurController::class, 'approveDemande']);
        Route::post('/admin/reject-demande/{id}', [AdministrateurController::class, 'rejectDemande']);
        // Route::post('/offres',[OffreController::class,'store']);
        // Route::get('/offres/{offres}',[OffreController::class,'show']);
        // Route::put('/offres/{offres}',[OffreController::class,'customUpdate']);
        // Route::post('/offres/{offres}/{activites}',[OffreController::class,'destroy']);
        // Route::get('/animateurs', [GroupeController::class, 'index']);
    });




/*
╔==========================================================================╗
║                           Parent Routes                                  ║
╚==========================================================================╝
*/
    Route::group([ 'prefix' => 'parent'], function () {



        Route::apiResource('enfants', EnfantController::class);
        Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class); 
        Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
        Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);
        
        // Route::get('parent/offres', [OffreController::class, 'index']);
        // Route::get('parent/offres/{offre}', [OffreController::class, 'show']);
        // Route::get('parent/offres/{offre}/details', [OffreController::class, 'showDetails']);
    });    


    
    
    
/*
╔==========================================================================╗
║                           Animateur Routes                              ║
╚==========================================================================╝
*/
    Route::group([ 'prefix' => 'animateur'], function () {
        
    
    
    
    
    });    




});



