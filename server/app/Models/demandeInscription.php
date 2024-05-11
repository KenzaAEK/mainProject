<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeInscription extends Model
{
    use HasFactory;
    protected $table = 'demande_inscriptions';
    public $timestamps = false;
    protected $primaryKey = 'idDemande';
    protected $fillable = [
        'optionsPaiement',
        'status',
        'idTuteur',
        'dateDemande',
        'idPack'
    ];
    

     public function administrateurs() {
        return $this->belongsToMany(Administrateur::class, 'admin_traiter', 'idDemande', 'idAdmin');
    }
    public function tuteur() {
        return $this->belongsTo(Tuteur::class, 'idTuteur');
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
