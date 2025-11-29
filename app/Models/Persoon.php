<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persoon extends Model
{
    protected $table = 'Persoon';

    public $timestamps = false;

    protected $fillable = [
        'GebruikerId',
        'Voornaam',
        'Tussenvoegsel',
        'Achternaam',
        'Geboortedatum',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function gebruiker()
    {
        return $this->belongsTo(Gebruiker::class, 'GebruikerId');
    }
}
