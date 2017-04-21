<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable {

    protected $table = "corporations";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nomeazienda', 'nomereferente', 'telefonoprimario',
        'emailprimaria', 'settore', 
        'emailsecondaria', 'fax', 'statoemotivo',
        'cf', 'cartadicredito', 'iban',
        'swift', 'sedelegale', 'indirizzospedizione',
        'logo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
	
    public function corporations()
    {
	return $this->hasMany(Corporation::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
