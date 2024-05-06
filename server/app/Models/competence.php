<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    protected $primaryKey = 'idCompetence';
    protected $fillable = ['nom_competence'];

    public function TypeActivite()
    {
        return $this->belongsToMany(typeActivite::class,  'competance_activites', 'idCompetence', 'idTypeActivite');
    }
    public function animateur()
    {
        return $this->belongsToMany(Animateur::class,  'animateur_competences', 'idCompetence', 'idAnim');
    }
   
}
