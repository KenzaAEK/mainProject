<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'idUser';
    protected $fillable = [
        
        'nom', 
        'prenom',
        'email',
        'tel', 
        'password',
        'role', 
        'photo',
        
    ];
    

    protected $hidden = [
        'password', 'remember_token', 'idUser'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function admin() {
        return $this->hasOne(Administrateur::class);
    }

    public function anim() {
        return $this->hasOne(Animateur::class);
    }

    public function parent() {
        return $this->hasOne(Tuteur::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'idUser');
    }
  
    
}
