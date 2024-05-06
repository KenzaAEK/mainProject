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
        return $this->hasMany(TypeActivite::class,  'idCompetence');
    }
   
}
