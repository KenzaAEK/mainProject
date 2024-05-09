<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'idPack';
    protected $table = 'packs';
    protected $fillable = [
        'remise',
        'type',
        'limite'
    ];
    
    public function demande_inscription()
    {
        return $this->hasMany(DemandeInscription::class, 'idPack');
    }
}
