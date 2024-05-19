<?php

namespace App\Models;
use App\Models\Offre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
// this association inscriptionEnfant_offre_Activite
    public function enfants() :BelongsToMany
    {
        return $this->belongsToMany(enfant::class,'inscriptionEnfant_offre_Activite')
                    ->withPivot('idDemande','idTuteur','idEnfant','idOffre','idActivite','PixtotalRemise','Prixbrute');
    }

   
    public function DemandeInscription() :BelongsToMany
    {
        return $this->belongsToMany(DemandeInscription::class,'inscriptionEnfant_offre_Activite')
                    ->withPivot('idDemande','idTuteur','idEnfant','idOffre','idActivite','PixtotalRemise','Prixbrute');
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
