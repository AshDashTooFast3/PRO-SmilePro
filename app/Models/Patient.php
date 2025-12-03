<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;


class Patient extends Model
{
    use HasFactory;

    protected $table = 'Patient';

    protected $primaryKey = 'Id';

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

    public static function getVolledigeNaamPatienten() {
        return DB::select('CALL sp_getVolledigeNaamPatienten()');
    }

    public static function getPatientFactuur($patientId) {
        return DB::select('CALL sp_getPatientFactuur(?)', [$patientId]);
    }

    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }

    public function facturen()
    {
        return $this->hasMany(Factuur::class, 'PatientId', 'Id');
    }
    
}
