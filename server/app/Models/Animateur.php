<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animateur extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAnimateur';
    protected $table = 'animateurs';

    protected $fillable = [
        'idUser',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
    }
    public function Competences()
    {
        return $this->belongsToMany(Competence::class,'animateur_competence','idAnimateur','id_competence');
    }
    public function horaires()
    {
        return $this->belongsToMany(Horaire::class,'disponibilite_animateur','idAnimateur','idHoraire');
    }
    public function groupes()
    {
        return $this->hasMany(Groupe::class, 'idAnimateur');
    }
}
