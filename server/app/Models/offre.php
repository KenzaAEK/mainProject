<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;
    protected $fillable = [
        'idAdmin',
        'remise',
        'dateDebutOffre',
        'dateFinOffre',
        'description',
    ];
     public function administrateur()
    {
        return $this->belongsTo(Administrateur::class, 'idAdmin');
    }

    public function offreActivites()
    {
        return $this->hasMany(OffreActivite::class, 'idOffre');
    }
}
