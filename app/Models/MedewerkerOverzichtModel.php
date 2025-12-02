<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedewerkerOverzichtModel extends Model
{
    protected $table = 'Medewerker';
    protected $primaryKey = 'Id';
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
        'Datumgewijzigd'
    ];

    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId', 'Id');
    }
}
