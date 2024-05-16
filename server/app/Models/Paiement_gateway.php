<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement_gateway extends Model
{
    use HasFactory;
    protected $table = 'paiement_gateway';
    protected $primaryKey = 'idPaiment';
    public $timestamps = false;
    public function offre_activite()
    {
        return $this->hasMany(Offre_activite::class, 'idPaiment');
    }
}
