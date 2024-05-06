<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeActivite extends Model
{
    use HasFactory;
    protected $primaryKey = 'type_activite_id';
    protected $fillable = [
        'activite_type',
        'domaine'
    ];




    public function activites()
    {
        return $this->hasMany(Activite::class, 'type_activite_id');
    }
    public function competance()
    {
        return $this->hasMany(competence::class, 'type_activite_id');
    }
   
}
