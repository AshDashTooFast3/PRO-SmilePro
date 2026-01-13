<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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

    // pakt alle berichten en eventuele errors

    public function getAllCommunicatie(): array
    {
        try {
            $result = DB::select('CALL sp_GetAllCommunicatie()');

            if (is_null($result)) {
                Log::warning('sp_GetAllCommunicatie retourneerde null.');

                return [];
            } elseif (empty($result)) {
                Log::info('sp_GetAllCommunicatie retourneerde een lege array.');

                return [];
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Fout in getCommunicatie: '.$e->getMessage());

            return [];
        }
    }

    public static function DeleteBericht(int $Id): bool
    {
        try {
            if (empty($Id) || $Id <= 0 || $Id === null) {
                Log::warning('Ongeldig bericht Id opgegeven voor verwijdering', ['BerichtId' => $Id]);

                return false;
            }

            DB::select('CALL sp_DeleteCommunicatie(?)', [$Id]);

            Log::info("Bericht Id {$Id} succesvol verwijderd.");
            return true;

        } catch (\Exception $e) {
            Log::error("Fout bij het verwijderen van bericht Id {$Id}: {$e->getMessage()}");

            return false;
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
