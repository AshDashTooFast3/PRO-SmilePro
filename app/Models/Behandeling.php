<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

const CREATED_AT = 'Datumaangemaakt';
const UPDATED_AT = 'Datumgewijzigd';

class Behandeling extends Model
{
    /** @use HasFactory<\Database\Factories\BehandelingFactory> */
    use HasFactory;

    protected $table = 'Behandeling';

    protected $fillable = [
        'MedewerkerId',
        'PatientId',
        'Datum',
        'Tijd',
        'Behandelingtype',
        'Omschrijving',
        'Kosten',
        'Status',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId');
    }
}
