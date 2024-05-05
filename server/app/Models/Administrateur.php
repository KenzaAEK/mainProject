<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;
    protected $table = 'administrateurs';  // S'assurer que le nom de la table est correct
    protected $primaryKey = 'idAdmin'; // Définir la clé primaire personnalisée
    public $incrementing = true; // Assumer que la clé primaire est auto-incrémentée
    protected $keyType = 'int'; // Assumer que la clé primaire est un entier

    protected $fillable = [
        'user_id', // La clé étrangère vers le modèle User
        'idAdmin'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'idUser'); // Spécifiez le nom de la clé étrangère si nécessaire
    }
}
