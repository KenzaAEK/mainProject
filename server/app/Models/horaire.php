<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horaire extends Model
{
    use HasFactory;
    protected $primaryKey = 'idHoraire';
    protected $table = 'horaires';
    protected $fillable = ['jour', 'heureDebut', 'heureFin'];
    public $timestamps = false;

    public function animateurs(){
        return $this->belongsToMany(Animateur::class,'disponibilite_animateur','idHoraire','idAnimateur');
    }
    public function offre_activite(){
        return $this->belongsToMany(offreActivite::class,'disponibilite_offreactivite','idHoraire','id_offreActivite');
    }
}
