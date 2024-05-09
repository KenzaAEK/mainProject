<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demandeInscription extends Model
{
    use HasFactory;
    protected $table = 'demande_inscription';
    protected $primaryKey = 'idDemande';
    protected $fillable = [
        'optionsPaiement',
        'status',
        'idTuteur',
        'dateDemande',
        'idPack'
    ];
    public $timestamps = false;

     public function administrateurs() {
        return $this->belongsToMany(Administrateur::class, 'admin_traiter', 'idDemande', 'idAdmin');
    }
    public function tuteurs() {
        return $this->belongsTo(Tuteur::class);
    }
    public function packs() {
        return $this->belongsTo(Pack::class);
    }
    public function devis() {
        return $this->hasOne(Devis::class, 'idDemande');
    }

    public function offre_activite() {
        return $this->belongsToMany(OffreActivite::class, 'inscriptionEnfant_offre_Activite', 'idDemande', 'idOffre','idActivite');
    }

    public function enfants() {
        return $this->belongsToMany(Enfant::class, 'inscriptionEnfant_offre_Activite', 'idDemande', 'idEnfant','idTuteur');    }
}
