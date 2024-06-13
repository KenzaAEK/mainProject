<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ActiviteController;
use App\Http\Controllers\Api\AdministrateurController;
use App\Http\Controllers\Api\OffreController;
use App\Http\Controllers\Api\DemandeInscriptionController;
use App\Http\Controllers\Api\DevisController;
use App\Http\Controllers\Api\EnfantController;
use App\Http\Controllers\Api\TypeActiviteController;
use App\Http\Controllers\Api\GroupeController;
use App\Http\Controllers\AnimateurController;
use App\Http\Controllers\FactureController;

/*
╔==========================================================================╗
║                           All Users Routes                               ║
╚==========================================================================╝
*/



// Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
// Route::post('/reset-password/{token}', [PasswordResetController::class, 'resetPassword'])->name('password.reset');




Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);






Route::apiResource('enfants', EnfantController::class);
Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class);

Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);







Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users



    Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);
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


    Route::post('/admin/approve-demande/{id}', [AdministrateurController::class, 'approveDemande']);
    Route::get('/admin/show-demande', [AdministrateurController::class, 'index']);
    Route::put('/admin/reject-demande', [AdministrateurController::class, 'rejectDemande']);

/*
╔==========================================================================╗
║                           Admin Routes                                   ║
╚==========================================================================╝
*/
    Route::group(['middleware' => 'role:2', 'prefix' => 'admin'], function () {
  
        Route::apiResource('activites', ActiviteController::class);
        Route::apiResource('type-activites', TypeActiviteController::class);
      
        Route::post('/admin/reject-demande/{id}', [AdministrateurController::class, 'rejectDemande']);
        
        // Route::post('/offres',[OffreController::class,'store']);
        // Route::get('/offres/{offres}',[OffreController::class,'show']);
        // Route::put('/offres/{offres}',[OffreController::class,'customUpdate']);
       //  Route::post('/offres/{offres}/{activites}',[OffreController::class,'destroy']);
       //  Route::get('/animateurs', [GroupeController::class, 'index']);
 
    });




/*
╔==========================================================================╗
║                           Parent Routes                                  ║
╚==========================================================================╝
*/
    Route::group([ 'prefix' => 'parent'], function () {



        Route::apiResource('enfants', EnfantController::class);
        Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class); 
        Route::post('/accept-devis/{id}', [DevisController::class, 'acceptDevis']);
        Route::post('/reject-devis/{id}', [DevisController::class, 'rejectDevis']);
        Route::get('/facture-download/{idFacture}', [FactureController::class, 'downloadPdf'])->name('facture.download');
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
    
    
    
    
    });    

    
   
   
   

   
    // ********Traitement Administrateurs**********
    
    


    // for admins only and authenticated  
    //add middlewear check role 
    Route::apiResource('activites', ActiviteController::class);







    //add middlewear check role 
    // for parents only and authenticated
  



    //add middlewear check role 
    // for animators only and authenticated 
    
    





});



