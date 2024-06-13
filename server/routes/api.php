<?php

use App\Http\Controllers\Api\AdministrateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ActiviteController;
// use App\Http\Controllers\Api\AdministrateurController;
use App\Http\Controllers\Api\OffreController;
// use App\Http\Controllers\Api\DemandeInscriptionController;
use App\Http\Controllers\Api\DevisController;
use App\Http\Controllers\Api\EnfantController;
use App\Http\Controllers\Api\Password\PasswordResetController;
use App\Http\Controllers\api\password\UpdatePasswordController;
use App\Http\Controllers\Api\TypeActiviteController;
use App\Http\Controllers\AnimateurController;
use App\Http\Controllers\Api\DemandeInscriptionController;

/*
╔==========================================================================╗
║                           All Users Routes                               ║
╚==========================================================================╝
*/

Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']);

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])->name('password.reset');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/*
╔==========================================================================╗
║                           All Users authenticated                        ║
╚==========================================================================╝
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users

    Route::apiResource('demande-Inscriptions', DemandeInscriptionController::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);
    Route::apiResource('activites', ActiviteController::class);
    Route::get('/ateliers', [ActiviteController::class, 'getAtelier']); // cette methode sera tres utile pour recuperer les atelier present !!![il faut appeler cette api en premier ] pour le store 
    Route::get('/users', [AuthController::class, 'index']);

    /*
    ╔==========================================================================╗
    ║                           Admin Routes                                   ║
    ╚==========================================================================╝
    */
    Route::group(['middleware' => 'role:1', 'prefix' => 'admin'], function () { // 2 !!!!!!!!!!!!!!!!!!!!!!!!!! 1 only for testing

        Route::apiResource('activites', ActiviteController::class);
        Route::apiResource('type-activites', TypeActiviteController::class);
        Route::post('/approve-demande/{id}', [AdministrateurController::class, 'approveDemande']);
        Route::post('/reject-demande/{id}', [AdministrateurController::class, 'rejectDemande']);

        // traitement de l'offres :
        Route::post('/offres', [OffreController::class, 'store']);
        Route::get('/offres/{offres}', [OffreController::class, 'show']);
        Route::put('/offres/{offres}', [OffreController::class, 'update']);
        Route::delete('/offres/{offres}/{activites}', [OffreController::class, 'deleteOffreActiviteById']); // suppr une activite lier a une offre 
        Route::delete('/offres/{offres}', [OffreController::class, 'deleteOffreActivitesByIdOffre']); // supprimer l'offre et tous  ces activites 
    });
});
