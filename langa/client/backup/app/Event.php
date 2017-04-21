<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    
    protected $fillable = ['name', 'ente', 'dipartimento', 'giorno', 'giornoFine', 'mese', 'meseFine', 'anno', 'annoFine', 'titolo', 'dettagli', 'eh', 'sh'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
