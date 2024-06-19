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
    
    protected $casts = [
        'heureDebut' => 'datetime',
        'heureFin' => 'datetime',
    ];
    public $timestamps = false;

    public function animateurs(){
        return $this->belongsToMany(Animateur::class,'disponibilite_animateur','idHoraire','idAnimateur');
    }
    
    
    public function offreActivites()
    {
        return $this->belongsToMany(offreActivite::class, 'disponibilite_offreactivite', 'idHoraire', 'idOffreActivite');
                    
    }
}

