<?php

namespace App\Models;
use App\Models\OffreActivite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Offre extends Model
{
    use HasFactory;
     protected $primaryKey = 'idOffre';
     public $incrementing = true; // Assurez-vous que cela est vrai si vous utilisez l'auto-incrémentation
     protected $keyType = 'int';
     protected $table = 'offres';
     public $timestamps = false;
     protected $fillable = [
        'idAdmin',
        'remise',
        'dateDebutOffre',
        'dateFinOffre',
        'description',
        'titre'
    ];

     

     public function administrateurs()
    {
        return $this->belongsTo(Administrateur::class);
    }

    public function offreActivite()
    {
        return $this->hasMany(OffreActivite::class, 'idOffre');
    }
   /* public static function createWithNextId($data)
    {
        $latestOffre = Offre::orderBy('idOffre', 'desc')->first();
        $nextId = $latestOffre ? $latestOffre->idOffre + 1 : 1;
    
        $offre = new Offre($data);
        $offre->idOffre = $nextId;
        $offre->save();
    
        return $offre;
    }*/
    
}

