<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActivite extends Model
{
    use HasFactory;

    protected $primaryKey = 'idTypeActivite';
    protected $table = 'type_activites';
    protected $fillable = [
        'type',
        'domaine'
    ];

    public $timestamps = false;


    public function activites()
    {
        return $this->hasMany(Activite::class, 'idActivite');
    }
    public function competance()
    {
        return $this->belongsToMany(competence::class,'competance_activite','id_Activite','id_competence');	
    }
    public static function getIdByType($type)
    {
        $typeActivite = self::where('type', $type)->first();
        return $typeActivite ? $typeActivite->idTypeActivite : null;
    }
}
