<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeActivite extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTypeActivite';
    protected $fillable = [
        'activite_type',
        'domaine'
    ];




    public function activites()
    {
        return $this->hasMany(Activite::class, 'idTypeActivite');
    }
    public function competance()
    {
        return $this->belongsTo(competence::class,'competance_activites','idTypeActivite','idCompetence');	
    }
   
}
