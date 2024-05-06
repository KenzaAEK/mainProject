<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;
    protected $primaryKey = 'competence_id';
    protected $fillable = ['nom_competence'];

    public function competanceActivites()
    {
        return $this->hasMany(TypeActivite::class, 'competence_id', 'competence_id');
    }
   
}
