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
    'idEnfant',
    'prenom',
    'nom',
    'dateNaissance',
    'niveauEtude', 
    'idTuteur'];
    public $incrementing = true;
    public $timestamps = false;
    public function tuteur() {
        return $this->belongsTo(Tuteur::class,'idTuteur'); // cest le parent
    }
    public function groupes() {
        return $this->belongsToMany(Groupe::class, 'enfant_groupes', 'idEnfant', 'idGroupe');
    }
    // public function inscriptionEnfant_offre_Activite() {
    //     return $this->hasOne(InscriptionEnfantOffreActivite::class, 'idEnfant');
    // }
    public function offre_activite()
    {
        return $this->belongsToMany(offreActivite::class, 'planning_enfant', 'idActivite', 'idEnfant','idTuteur','idOffre');
    }
    // public function offreActivite() {
    //     return $this->belongsToMany(OffreActivite::class, 'planning', 'idEnfant', 'idOffreActivite');
        
    // }

}
