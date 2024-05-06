<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inscriptionEnfantOffreActivite extends Model
{
    use HasFactory;
    protected $table = 'inscription_enfant_offre_activites';
    protected $primaryKey = 'idInscriptionEnfantOffreActivite';
    protected $fillable = [
        'idEnfant',
        'idOffreActivite',
        'idDemande',
        'idPack'
    ];
    public function enfant()
    {
        return $this->belongsTo(Enfant::class, 'idEnfant', 'idEnfant');
    }

    public function offreActivite()
    {
        return $this->belongsTo(OffreActivite::class, 'idOffreActivite');
    }

    public function demandeInscription()
    {
        return $this->belongsTo(DemandeInscription::class, 'idDemande');
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class,  'idPack');
    }
}

