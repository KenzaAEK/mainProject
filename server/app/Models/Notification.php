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

    // Méthodes pour marquer les notifications comme lues ou non
    public function markAsRead()
    {
        $this->statut = true;
        $this->save();
    }

    public function markAsUnread()
    {
        $this->statut = false;
        $this->save();
    }

    // Relier les notifications aux utilisateurs
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function factures()
    {
        return $this->hasone(Facture::class,'idNotification');
    }

    public function devis()
    {
        return $this->hasone(Devis::class,'idNotification');
    }
}
