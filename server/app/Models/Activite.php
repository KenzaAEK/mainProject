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
<<<<<<< HEAD
        'titre', 'description', 'objectif', 'ageMin', 'ageMax', 'imagePub', 'lienYtb', 'programmePdf','idTypeActivite'
=======
        'titre', 'description', 'objectif', 'imagePub', 'lienYtb', 'programmePdf','id_Activite'
>>>>>>> 44640682812d6c5cdc5422d6f02a6666d659bc99
    ];

    public function offre_activite()
    {
        return $this->hasMany(Offre_activite::class, 'idActivite');
    }
    public function typeActivite()
    {
        return $this->belongsTo(TypeActivite::class);
    }
}
