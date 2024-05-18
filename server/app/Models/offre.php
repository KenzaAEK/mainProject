<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;
    protected $primaryKey = 'idOffre';
    protected $table = 'offres';
    public $timestamps = false;
    protected $fillable = [
        'idAdmin',
        'remise',
        'dateDebutOffre',
        'dateFinOffre',
        'description',
    ];
     public function administrateurs()
    {
        return $this->belongsTo(Administrateur::class);
    }

    public function offre_activite()
    {
        return $this->hasMany(OffreActivite::class, 'idOffre');
    }
}
