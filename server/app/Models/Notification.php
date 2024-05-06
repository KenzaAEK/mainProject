<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';  // S'assurer que le nom de la table est correct
     
    protected $primaryKey = 'idNotif';
    protected $fillable = [
        'idUser', 
        'objet', // Supposons que 'objet' contienne le contenu ou le sujet de la notification
        'isRead' // Un booléen qui indique si la notification a été lue
    ];

    // Méthodes pour marquer les notifications comme lues ou non
    public function markAsRead()
    {
        $this->isRead = true;
        $this->save();
    }

    public function markAsUnread()
    {
        $this->isRead = false;
        $this->save();
    }

    // Relier les notifications aux utilisateurs
    public function users()
    {
        return $this->belongsTo(User::class,'idUser');
    }
    public function facture()
    {
        return $this->hasone(Facture::class,'idNotif');
    }
}


