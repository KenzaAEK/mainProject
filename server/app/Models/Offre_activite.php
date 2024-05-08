<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre_activite extends Model
{
    use HasFactory;
    protected $primaryKey = ['idOffre', 'idActivite'];
    protected $table = 'offre_activite';
    protected $fillable = [
        'tarif',
        'effmax',
        'effmin',
        'nbrSeance',
        'Duree_en_heure',
        'idOffre',
        'idPaiment',
        'idActivite',
        'age_max',
        'age_max'
        ];
    
    
    
    public function offres()
    {
        return $this->belongsTo(Offre::class);
    }

    public function paiement_gateway()
    {
        return $this->belongsTo(Paiement_gateway::class);
    }

    public function activites()
    {
        return $this->belongsTo(Activite::class);
    }
    //enfant + demande inscription + groupe ???????????????????
    //¿????????????????????????????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿?????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿???????????
    public function horaires()
    {
        return $this->belongsToMany(Horaire::class,'disponibilite_offreactivite', 'idActivite','idOffre','idHoraire');
    }
    public function enfants()
    {
        return $this->belongsToMany(Enfant::class, 'planning_enfant', 'idActivite', 'idEnfant','idTuteur','idOffre');
    }

    public function groupes(){
        return $this->hasOne(Groupe::class, 'idGroupe');
    }

    public function demande_inscription()
    {
        return $this->belongsToMany(Demande_inscription::class, 'inscriptionEnfant_offre_Activite', 'idActivite', 'idDemande','idOffre');
    }

}
