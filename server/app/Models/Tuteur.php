<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTuteur'; // S'assurer que le nom de la table est correct
    protected $table = 'tuteurs';
    protected $fillable = [
        'idUser', // La clé étrangère vers le modèle User
        'fonction', // Je suppose que c'est le champ 'fonction' que vous avez ajouté
    ];

    public function users() {
        return $this->belongsTo(User::class);
        
    }
    public function demande_inscription() {
        return $this->hasMany(DemandeInscription::class, 'idTuteur');
    }
    public function enfants() {
        return $this->hasMany(Enfant::class, 'idTuteur');
    }
}
