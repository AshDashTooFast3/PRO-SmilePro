<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;


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

    //pakt alle berichten en eventuele errors

    public function getAllCommunicatie()
    {
        try {
            $result = DB::select('CALL sp_GetAllCommunicatie()');

            return $result;

        } catch (\Exception $e) {
            Log::error('Fout in getCommunicatie: '.$e->getMessage());
            return [];
        }
    }

    // een bericht hoort bij een patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId');
    }

    // een bericht hoort bij een medewerker
    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId');
    }
}
    