<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentGateway extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPayment';

    public function offreActivites()
    {
        return $this->hasMany(OffreActivite::class, 'idPayment');
    }
}
