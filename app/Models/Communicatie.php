<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class Communicatie extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'Communicatie';

    public $timestamps = false;

    protected $fillable = [
        'PatientId',
        'MedewerkerId',
        'Bericht',
        'VerzondenDatum',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public function getAllCommunicatie()
    {
        return DB::select("SELECT * FROM communicatie WHERE Isactief = 1");
    }

    // A Bericht belongs to a Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId');
    }

    // A Bericht belongs to a Medewerker
    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId');
    }
}
    