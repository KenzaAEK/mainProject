<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offreActivite extends Model
{
    use HasFactory;
    protected $primaryKey = 'idOffreActivite';

    protected $fillable = [
        'tarif',
        'effmax',
        'effmin',
        'nbrSeance',
        'Duree',
        'idOffre',
        'idPayment',
        'idActivite'
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
        return $this->belongsToMany(Enfant::class, 'idActivite');
    }
    public function demandeInscription()
    {
        return $this->belongsToMany(demandeInscription::class, 'idActivite');
    }
    

    
}
