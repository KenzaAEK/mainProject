<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enfant extends Model
{
    use HasFactory;
    protected $table = 'enfants';
    protected $primaryKey = 'idEnfant';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
    'idEnfant',
    'prenom',
    'nom',
    'dateNaissance',
    'niveauEtude', 
    'idTuteur'];
    public function tuteur() {
        return $this->belongsTo(Tuteur::class,'idTuteur'); // cest le parent
    }
    public function groupes() {
        return $this->belongsToMany(Groupe::class, 'enfant_groupe', 'idEnfant', 'idGroupe')
        ->withPivot('idTuteur'); // Si vous avez besoin d'accéder à idTuteur depuis la relation
     }
    
    // public function inscriptionEnfant_offre_Activite() {
    //     return $this->hasOne(InscriptionEnfantOffreActivite::class, 'idEnfant');
    // }
    public function offre_activite()
    {
        return $this->belongsToMany(offreActivite::class, 'planning_enfant', 'idActivite', 'idEnfant','idTuteur','idOffre');
    }
    
    //for autoincrement of idEnfant
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastEnfantId = Enfant::max('idEnfant') ?? 0;
            $model->idEnfant = $lastEnfantId + 1;
        });
    }

}
