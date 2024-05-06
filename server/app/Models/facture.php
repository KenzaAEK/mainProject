<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    //public $timestamps = false;
    protected $table = 'factures';
    protected $primaryKey = 'idFacture';

    protected $fillable = [
        'totalHT', 
        'totalTTC', 
        'dateFacture', 
        'idNotif',
        'facturePdf'
    ];

    // Relation avec FactureNotif (si nécessaire selon le contexte de l'application)
    public function Notofication()
    {
        return $this->belongsTo(Notification::class,'idNotif');
    }

    
    // Relation avec Devis (supposée générer une Facture)
    public function devis() {
        return $this->belongsTo(Devi::class, 'idDevis');
    }
}
