<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Administrateur;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
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

    public function adminisatrateur() {
        return $this->hasOne(Administrateur::class, 'idUser');
    }

    public function animateur() {
        return $this->hasOne(Animateur::class, 'idUser');
    }

    public function tuteur() {
        return $this->hasOne(Tuteur::class, 'idUser');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'idUser');
    }
}
