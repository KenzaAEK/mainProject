<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    use HasFactory;

  
    use HasFactory;
    protected $primaryKey = 'idTuteur'; // S'assurer que le nom de la table est correct
   
    public $timestamps = false;
    protected $fillable = [
        'idUser', // La clé étrangère vers le modèle User
        'fonction', // Je suppose que c'est le champ 'fonction' que vous avez ajouté
        
    ];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
        
    }
    public function demandeInscription() {
        return $this->hasMany(demandeInscription::class, 'idTuteur');
    }
    public function enfants() {
        return $this->hasMany(Enfant::class, 'idTuteur');
    }
}
