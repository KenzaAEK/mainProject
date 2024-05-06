<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $primaryKey = 'idGroupe';

    protected $fillable = [
        'Nomgrp',
        'idOffreActivite'
    ];

    public function animateur()
    {
        return $this->belongsToMany(Animateur::class, 'Animateur_groupes', 'idGroupe', 'idAnim');
    }
   
    public function offreActivite()
    {
        return $this->belongsTo(offreActivite::class, 'idOffreActivite');
    }
    public function enfant() {
        return $this->belongsToMany(Enfant::class, 'enfant_groupes', 'idGroupe', 'idEnfant');
    }
    

  
}
