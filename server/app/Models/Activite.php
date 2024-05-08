<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activite extends Model
{
    use HasFactory;

    protected $primaryKey = 'idActivite';
    protected $table = 'activites';
    protected $fillable = [
        'titre', 'description', 'objectif', 'imagePub', 'lienYtb', 'programmePdf','idTypeActivite'
    ];

    public function offre_activite()
    {
        return $this->hasMany(Offre_activite::class, 'idActivite');
    }
    public function typeActivite()
    {
        return $this->belongsTo(Type_activite::class);
    }
}
