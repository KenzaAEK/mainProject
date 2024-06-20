<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    protected $primaryKey = 'idCompetence';
    protected $table = 'competences';
    public $timestamps = false;
    protected $fillable = ['nom_competence'];

    public function typeactivites()
    {
        return $this->belongsToMany(TypeActivite::class,  'competance_activite', 'id_competence', 'id_Activite');
    }
    public function animateurs()
    {
        return $this->belongsToMany(Animateur::class,  'animateur_competence', 'id_competence', 'idAnimateur');
    }
}
