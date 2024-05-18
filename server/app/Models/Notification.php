<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';  // S'assurer que le nom de la table est correct
     
    protected $primaryKey = 'idNotification';
    protected $fillable = [
        'idUser', 
        'contenu', // Supposons que 'objet' contienne le contenu ou le sujet de la notification
        'statut' // Un booléen qui indique si la notification a été lue
    ];
    protected $casts = [
        'statut' => 'boolean',
        'read_at' => 'datetime',  
    ];
    // Méthodes pour marquer les notifications comme lues ou non
    public function markAsRead()
    {
        $this->statut = true;
        $this->read_at = now();
        $this->save();
    }

    public function markAsUnread()
    {
        $this->statut = false;
        $this->read_at = null;  
        $this->save();
    }

    // Relier les notifications aux utilisateurs
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');    }
    public function Facture()
    {
        return $this->hasone(Facture::class,'idNotification');
    }

    public function Devis()
    {
        return $this->hasone(Devis::class,'idNotification');
    }
}
