<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'Patient';

    public $timestamps = false;

    protected $fillable = [
        'PersoonId',
        'Nummer',
        'MedischDossier',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    // A Patient belongs to a Persoon
    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }
}
