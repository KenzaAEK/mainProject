<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;
    protected $primaryKey = 'idActivite';

    protected $fillable = [
        'titre', 'description', 'objectif', 'ageMin', 'ageMax', 'imagePub', 'lienYtb', 'programmePdf'
    ];

    public function offreActivite()
    {
        return $this->hasOne(OffreActivite::class, 'activite_id', 'idActivite');
    }
    public function typeActivite()
    {
        return $this->belongsTo(TypeActivite::class, 'idTypeActivite');
    }
}
