<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;
    protected $primaryKey = 'idActivite';

    protected $fillable = [
        'titre', 'description', 'objectif', 'ageMin', 'ageMax', 'imagePub', 'lienYtb', 'programmePdf','idTypeActivite'
    ];

    public function offreActivite()
    {
        return $this->hasOne(OffreActivite::class, 'idActivite');
    }
    public function typeActivite()
    {
        return $this->belongsTo(TypeActivite::class, 'idTypeActivite');
    }
}
