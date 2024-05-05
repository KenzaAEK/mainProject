<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
<<<<<<< HEAD
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('tel');
            $table->string('photo')->nullable();
            $table->rememberToken();
            $table->timestamps();    
        });
=======
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';  // S'assurer que le nom de la table est correct
    protected $primaryKey = 'idUser'; // Here you specify your custom primary key
    public $incrementing = true; // If your primary key is auto-incrementing
    protected $keyType = 'int'; // Assuming the primary key is an integer

    protected $fillable = [
        'nom', 
        'prenom',
        'email',
        'telephone', 
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
>>>>>>> d7521f112cadcf922a7da2f857b60d65fe958aa5
    }

    public function anim() {
        return $this->hasOne(Animateur::class);
    }

    public function parent() {
        return $this->hasOne(Parent::class);
    }
}
