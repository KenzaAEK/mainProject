<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_grp';
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
        return $this->belongsTo(Animateur::class);
    }
   
    public function offre_activite()
    {
        return $this->belongsTo(OffreActivite::class);
    }
    public function enfants() {
        return $this->belongsToMany(Enfant::class, 'enfant_groupe', 'id_grp', 'idEnfant','idTuteur');
    }
}