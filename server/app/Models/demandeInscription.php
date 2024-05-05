<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demandeInscription extends Model
{
    use HasFactory;
      public $timestamps = false;
    protected $table = 'demandeInscriptions';
    protected $primaryKey = 'idDemande';
    protected $fillable = [
        'optionsPaiement',
        'status',
        'dateDemande'
    ];

    
    protected $hidden = [];

    
    protected $casts = [];

     public function administrateurs() {
        return $this->belongsToMany(Administrateur::class, 'traiter', 'idDemande', 'idAdmin');
    }
    public function Tuteur() {
        return $this->belongsTo(Parent::class, 'idTuteur');
    }
}

