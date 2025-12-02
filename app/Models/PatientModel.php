<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientModel extends Model
{
    protected $table = 'patients';

    protected $primaryKey = 'id';

    protected $fillable = [
        'PersoonId',
        'Nummer',
        'MedischDossier',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public $timestamps = true;
}
