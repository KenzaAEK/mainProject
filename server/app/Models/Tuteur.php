<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    
    protected $table = 'tuteurs';  // S'assurer que le nom de la table est correct
    protected $primaryKey = 'idTuteur'; // Définir la clé primaire personnalisée
    public $incrementing = true; // Assumer que la clé primaire est auto-incrémentée
    protected $keyType = 'int'; // Assumer que la clé primaire est un entier
    public $timestamps = false;
    protected $fillable = [
        'user_id', // La clé étrangère vers le modèle User
        'idTuteur',
        'fonction',
        
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'idUser'); // Spécifiez le nom de la clé étrangère si nécessaire
    }
}

