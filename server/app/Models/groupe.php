<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $primaryKey = 'idGroupe';

    protected $fillable = ['Nomgrp', 'idOffreActivite'];

    public function animateur()
    {
        return $this->belongsToMany(Animateur::class, 'idAnimateur');
    }
    public function enfant()
    {
        return $this->belongsToMany(Enfant::class, 'idEnfant');
    }
    //???????????????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿
    public function offreActivite()
    {
        return $this->hasOne(offreActivite::class, 'idOffreActivite');
    }


  
}
