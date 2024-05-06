<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devi extends Model
{
    use HasFactory;
    
    
    protected $table = 'devis';
    protected $primaryKey = 'idDevis';
    
    protected $fillable = [
        'totalHT',
        'totalTTC',
        'TVA',
        'devisPdf',
        'datedevis'
    ];




    public function facture() {
        return $this->hasOne(Facture::class, 'idDevis');
    }
    public function demandeInscription() {
        return $this->belongsTo(demandeInscription::class, 'idDemande');
    }
}
