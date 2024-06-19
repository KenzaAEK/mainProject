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
        'idNotification',
        'facturePdf'
    ];

    // Relation avec FactureNotif (si nécessaire selon le contexte de l'application)
    public function notification()
    {
        return $this->belongsTo(Notification::class, 'idNotification');
    }

    
    // Relation avec Devis (supposée générer une Facture)
    public function devis() {
        return $this->hasMany(Devis::class, 'idFacture');
    }
}
