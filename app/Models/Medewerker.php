<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medewerker extends Model
{
    protected $table = 'Medewerker';

    public $timestamps = false;

    protected $fillable = [
        'PersoonId',
        'Nummer',
        'Medewerkertype',
        'Specialisatie',
        'Beschikbaarheid',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    // A Medewerker belongs to a Persoon
    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }

}
