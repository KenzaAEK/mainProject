<?php

use App\Http\Controllers\Api\AdministrateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ActiviteController;
// use App\Http\Controllers\Api\AdministrateurController;
use App\Http\Controllers\Api\OffreController;
use App\Http\Controllers\Api\DemandeInscriptionController;
use App\Http\Controllers\Api\DevisController;
use App\Http\Controllers\Api\EnfantController;
use App\Http\Controllers\password\PasswordResetController;
use App\Http\Controllers\Api\TypeActiviteController;
use App\Http\Controllers\Api\GroupeController;
use App\Http\Controllers\AnimateurController;
use App\Http\Controllers\FactureController;
//use App\Http\Controllers\AnimateurController;

/*
╔==========================================================================╗
║                           All Users Routes                               ║
╚==========================================================================╝
*/


/* Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [PasswordResetController::class, 'reset']); */
Route::get('/activites', [ActiviteController::class, 'index']);
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])->name('password.reset');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/offres',[OffreController::class,'index']);
/*
╔==========================================================================╗
║                           All Users authenticated                        ║
╚==========================================================================╝
*/
Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users
    Route::get('/login', [AuthController::class, 'index']);// pas encore tester pour corriger les porbleme  de production de projet
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);
    Route::apiResource('activites', ActiviteController::class);
    Route::get('/ateliers',[ActiviteController::class ,'getAtelier' ]);// cette methode sera tres utile pour recuperer les atelier present !!![il faut appeler cette api en premier ] pour le store 
    Route::get('/users', [AuthController::class, 'index']);

Route::apiResource('enfants', EnfantController::class);
Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class);

Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);


    // Route::post('/upload-image', [ProfileController::class, 'uploadImage']);
    // Route::post('/profile', [ProfileController::class, 'profile']);
    // Route::post('/udpdate-profile', [ProfileController::class, 'updateProfile']); //gate for animateur**** email 
    // Route::post('/password/update', [ UpdatePasswordController::class, 'UpdatePassword']);

    // // Manage notifications
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
    Route::group(['middleware' => 'role:2', 'prefix' => 'admin'], function () { // 2 !!!!!!!!!!!!!!!!!!!!!!!!!! 1 only for testing
        
        Route::apiResource('activites', ActiviteController::class);
        //Route::post('activites', ActiviteController::class,'store' );
        Route::apiResource('type-activites', TypeActiviteController::class);
        Route::post('/approve-demande/{id}', [AdministrateurController::class, 'approveDemande']);
        Route::post('/reject-demande/{id}', [AdministrateurController::class, 'rejectDemande']);
        Route::get('/show-demande', [AdministrateurController::class, 'index']);
        // Route::post('/offres',[OffreController::class,'store']);
        // Route::get('/offres/{offres}',[OffreController::class,'show']);
        // Route::put('/offres/{offres}',[OffreController::class,'customUpdate']);
       //  Route::post('/offres/{offres}/{activites}',[OffreController::class,'destroy']);
        // Route::get('/animateurs', [GroupeController::class, 'index']);
        // traitement de l'offres :
        Route::post('/offres',[OffreController::class,'store']);
        Route::get('/offres/{offres}',[OffreController::class,'show']);
        Route::put('/offres/{offres}',[OffreController::class,'update']);
        Route::delete('/offres/{offres}/{activites}',[OffreController::class,'deleteOffreActiviteById']);// suppr une activite lier a une offre 
        Route::delete('/offres/{offres}',[OffreController::class,'deleteOffreActivitesByIdOffre']);// supprimer l'offre et tous  ces activites 
        // Route::get('/animateurs', [GroupeController::class, 'index']);
    // for admins only and authenticated  
    //add middlewear check role 
        // Route::apiResource('activites', ActiviteController::class);
    //add middlewear check role 
    // for parents only and authenticated
    //add middlewear check role 
    // for animators only and authenticated 
 
    });
/*
╔==========================================================================╗
║                           Parent Routes                                  ║
╚==========================================================================╝
*/
    Route::group(['middleware' => 'role:1', 'prefix' => 'parent'], function () {



        Route::apiResource('enfants', EnfantController::class);
        // Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class); 
        Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
        Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);
        Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
        Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);
        
        // Route::get('parent/offres', [OffreController::class, 'index']);
        // Route::get('parent/offres/{offre}', [OffreController::class, 'show']);
        // Route::get('parent/offres/{offre}/details', [OffreController::class, 'showDetails']);
    });      
    
/*
╔==========================================================================╗
║                           Animateur Routes                               ║
╚==========================================================================╝
*/
    Route::group([ 'middleware' => 'role:3', 'prefix' => 'animateur'], function () {
       
        Route::get('/Animateurs',[AnimateurController::class,'AffAnimConnecter']);// Afficher ici les informations de l'Animateur connecter
        Route::get('/AnimateursEnf',[AnimateurController::class,'AffEtudAnim']);
        Route::get('/search_students',[AnimateurController::class,'searshEtud']);
        Route::apiResource('activites', ActiviteController::class);
        Route::get('/ateliers',[ActiviteController::class ,'getAtelier' ]);// cette methode sera tres utile pour recuperer les atelier present !!![il faut appeler cette api en premier ] pour le store 
        //Route::get('/Animateurs',[AnimateurController::class,'AffAnimConnecter']);// Afficher ici les informations de l'Animateur connecter
        //Route::get('/AnimateursEnf',[AnimateurController::class,'AffEtudAnim']);
        //Route::get('/search_students',[AnimateurController::class,'searshEtud']);
    
    
    
    });    

});