<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';  // S'assurer que le nom de la table est correct
    protected $primaryKey = 'idUser'; // Here you specify your custom primary key
    public $incrementing = true; // If your primary key is auto-incrementing
    protected $keyType = 'int'; // Assuming the primary key is an integer

    protected $fillable = [
        'nom',
        'prenom',
        'password',
        'tel',
        'email',
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
        return $this->hasOne(Parent::class);
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
