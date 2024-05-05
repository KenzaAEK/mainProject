<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animateur extends Model
{
    use HasFactory;
    protected $primaryKey = 'idAnim';
    public $timestamps = false;
    protected $fillable = [
        'idUser',
        
    ];

    public function user() {
        return $this->belongsTo(User::class, 'idUser');  
       }
}
