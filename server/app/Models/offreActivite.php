<?php

namespace App\Models;
use App\Models\Offre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offreActivite extends Model
{
    use HasFactory;
    
    protected $table = 'offreactivites';
    public $timestamps = false; 
    public $incrementing = false;

    
    protected $fillable = [
        'tarif',
        'effmax',
        'effmin',
        'nbrSeance',
        'Duree_en_heure',
        'idOffre',
        'idActivite',
        'age_max',
        'age_min'
        ];
    
    
    public function offre()
    {
        return $this->belongsTo(Offre::class, 'idOffre');
    }

   
    public function activite()
    {
        return $this->belongsTo(Activite::class, 'idActivite');
    }
    //enfant + demande inscription + groupe ???????????????????
    //¿????????????????????????????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿?????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿???????????
   
    public function horaire()
    {
        return $this->belongsToMany(Horaire::class, 'disponibilite_offreactivite', 'idOffreactivite', 'idHoraire');
    }
   
    public function enfant()
    {
        return $this->belongsToMany(Enfant::class, 'planning', 'idOffreActivite', 'idEnfant');
    }
   
    public function inscriptionEnfantOffreActivite()
    {
        return $this->hasOne(inscriptionEnfantOffreActivite::class, 'idInscriptionEnfantOffreActivite');
    }
   
    public function groupe(){
        return $this->hasOne(Groupe::class, 'idGroupe');
    }

    public function getAteliers()
    {
        $ateliers = Activite::all();
        return response()->json($ateliers);
    }
    

    
}
