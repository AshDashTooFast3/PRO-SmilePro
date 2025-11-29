<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Gebruiker as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Gebruiker extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Gebruiker';

    public $timestamps = false;

    protected $fillable = [
        'Gebruikersnaam',
        'Wachtwoord',
        'Email',
        'RolNaam',
        'Ingelogd',
        'Uitgelogd',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    protected $hidden = [
        'Wachtwoord',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'Wachtwoord' => 'hashed',
            'Ingelogd' => 'datetime',
            'Uitgelogd' => 'datetime',
        ];
    }

    // Een Gebruiker heeft veel Personen
    public function personen()
    {
        return $this->hasMany(Persoon::class, 'GebruikerId');
    }
    
    public function getAuthPassword()
{
    return $this->Wachtwoord;
}

}
