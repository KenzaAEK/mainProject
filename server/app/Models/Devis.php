<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;
    protected $table = 'devis';
    protected $primaryKey = 'idDevis';
    public $timestamps = false;
    protected $fillable = [
        'totalHT',
        'totalTTC',
        'TVA',
        'devisPdf',
        'datedevis',
        'idFacture',
        'idDemande',
        'idNotification'
    ];




    public function factures() {
        return $this->hasOne(Facture::class, 'idDevis');
    }
    public function demandeInscription() {
        return $this->belongsTo(Demande_Inscription::class);
    }
    public function notifications() {
        return $this->hasOne(Notification::class, 'idDevis');
    }
}
