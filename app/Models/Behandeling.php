<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Behandeling extends Model
{
    /** @use HasFactory<\Database\Factories\BehandelingFactory> */
    use HasFactory;
    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

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

    public function VoorkomendeBehandelingen()
    {
        return DB::SELECT('CALL sp_getVoorkomendeBehandelingen()');
    }
    
    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId');
    }
}
