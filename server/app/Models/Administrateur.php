<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    use HasFactory;

    protected $table = 'administrateurs';  // S'assurer que le nom de la table est correct
    protected $primaryKey = 'idAdmin';

    protected $fillable = [
        'idUser', 
    ];
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(User::class, 'idUser');
      
    }
}
