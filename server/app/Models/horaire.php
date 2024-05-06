<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;
    protected $primaryKey = 'idHoraire';

    protected $fillable = ['jour', 'heureDebut', 'heureFin'];


    public function animateur(){
        return $this->belongsToMany(Animateur::class,'disponibilite_animateurs','idHoraire','idAnim');
    }
    public function offreActivite(){
        return $this->belongsToMany(offreActivite::class,'disponibilites','idHoraire','idOffreActivite' );
    }
}
