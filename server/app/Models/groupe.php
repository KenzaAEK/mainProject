<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $primaryKey = 'idGroupe';
    public $timestamps = false;
    protected $table = 'groupes';
    protected $fillable = [
        'Nomgrp',
        'idActivite',
        'idOffre',
        'idAnimateur'  
    ];

    public function animateurs()
    {
        return $this->belongsToMany(Animateur::class, 'animateur_groupes', 'idGroupe', 'idAnimateur');
    }
   
    public function offre_activite()
    {
        return $this->belongsTo(offreActivite::class);
    }
    public function enfants() {
        return $this->belongsToMany(Enfant::class, 'enfant_groupe', 'idGroupe', 'idEnfant')
        ->withPivot('idTuteur'); 
    }

    public function horaires() {
        return $this->belongsToMany(Horaire::class, 'disponibilite_groupe', 'idGroupe', 'idHoraire');
    }
    public function offreactivite() {
        return $this->belongsTo(offreActivite::class, 'idOffreactivite');
    }
    
}