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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
Route::post('/devis/{id}/reject', [DevisController::class, 'rejectDevis']);



Route::post('/admins/approve-demande/{id}', [AdministrateurController::class, 'approveDemande']);
Route::post('/admin/reject-demande/{id}', [AdministrateurController::class, 'rejectDemande']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    // for authenticated users
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refreshToken']);
    Route::apiResource('activites', ActiviteController::class);
    Route::get('/ateliers',[ActiviteController::class ,'getAtelier' ]);// cette methode sera tres utile pour recuperer les atelier present !!![il faut appeler cette api en premier ] pour le store 
    
   //********Traitement d'Animateurs*************** 
   
   
   
   
    // ********Traitement Administrateurs**********
    
    // traitement de l'offres :
    Route::post('/offres',[OffreController::class,'store']);
    Route::get('/offres/{offres}',[OffreController::class,'show']);
    Route::put('/offres/{offres}',[OffreController::class,'update']);
    Route::delete('/offres/{offres}/{activites}',[OffreController::class,'deleteOffreActiviteById']);// suppr une activite lier a une offre 
    Route::delete('/offres/{offres}',[OffreController::class,'deleteOffreActivitesByIdOffre']);// supprimer l'offre et tous  ces activites 
    Route::get('/animateurs', [GroupeController::class, 'index']);


    // for admins only and authenticated  
    //add middlewear check role 
    Route::apiResource('activites', ActiviteController::class);







    //add middlewear check role 
    // for parents only and authenticated
    Route::apiResource('enfants', EnfantController::class);
    Route::apiResource('demande-Inscriptions', DemandeInscriptionController ::class); 
    Route::post('/devis/{id}/accept', [DevisController::class, 'acceptDevis']);
    Route::post('/devis/{id}/reject', [App\Http\Controllers\DevisController::class, 'rejectDevis']);



    //add middlewear check role 
    // for animators only and authenticated 
    
    





});



