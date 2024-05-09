<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeactivite extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTypeActivite';
    protected $table = 'typeactivites';
    protected $fillable = [
        'type',
        'domaine'
    ];

    public $timestamps = false;


    public function activites()
    {
        return $this->hasMany(Activite::class, 'id_Activite');
    }
    public function competance()
    {
        return $this->belongsToMany(competence::class,'competance_activite','id_Activite','id_competence');	
    }
}
