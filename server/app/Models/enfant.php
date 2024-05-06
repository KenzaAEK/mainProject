<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;

    protected $table = 'enfants';
    protected $primaryKey = 'idEnfant';
    protected $fillable = [
    'prenom',
    'nom',
    'dateNaissance',
    'niveauEtude', 
    'idTuteur'];

    public function Tuteur() {
        return $this->belongsTo(Tuteur::class, 'idTuteur');
    }
    public function groupes() {
        return $this->belongsToMany(Groupe::class, 'enfant_groupes', 'idEnfant', 'idGroupe');
    }
    
}