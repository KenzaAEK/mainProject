<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\XmlConfiguration\Group;

class Animateur extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAnim';
    public $timestamps = false;
    protected $fillable = [
        'idUser',
        'domaineCompetence'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');  
    }
    public function Competene()
    {
        return $this->belongsToMany(Competence::class,'animateur_competences','idAnim','idCompetence');
    }
    public function horaire()
    {
        return $this->belongsToMany(Competence::class,'animateur_competences','idAnim','idCompetence');
    }
    public function Groupe()
    {
        return $this->belongsToMany(Groupe::class,'Animateur_groupes','idAnim','idGroupe');
    }

}
