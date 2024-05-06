<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPack';

    protected $fillable = [
        'remise',
        'typePack',
    ];
    public function demandeInscription()
    {
        return $this->hasMany(demandeInscription::class, 'idPack');
    }
}
