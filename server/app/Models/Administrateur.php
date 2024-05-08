<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;
    protected $table = 'administrateurs';  // S'assurer que le nom de la table est correct
    protected $primaryKey = 'idAdmin';

    protected $fillable = [
        'idUser', 
    ];

    public function users() {
        return $this->belongsTo(User::class);
      
    }
    public function offres() {
        return $this->hasMany(Offre::class,'idAdmin');
      
    }
    public function demande_inscription() {
        return $this->belongsToMany(Demande_inscription::class, 'admin_traiter', 'idAdmin', 'idDemande');
    }
    
}
