<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offreActivite extends Model
{
    use HasFactory;
    protected $primaryKey = ['idOffre', 'idActivite'];
    protected $table = 'offreactivite';
    
    protected $fillable = [
        'tarif',
        'effmax',
        'effmin',
        'nbrSeance',
        'Duree_en_heure',
        'idOffre',
        'idActivite',
        'age_max',
        'age_max'
        ];
    
    
    public function offre()
    {
        return $this->belongsTo(Offre::class, 'idOffre');
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'idPayment')->withDefault();
    }

    public function activite()
    {
        return $this->belongsTo(Activite::class, 'idActivite');
    }
    //enfant + demande inscription + groupe ???????????????????
    //¿????????????????????????????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿¿?????????????¿¿¿¿¿¿¿¿¿¿¿¿¿¿???????????
    public function horaire()
    {
        return $this->belongsToMany(Horaire::class, 'idActivite');
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

    
    

    
}
