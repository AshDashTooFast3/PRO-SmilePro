<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Afspraken extends Model
{
    use HasFactory;

    protected $table = 'Afspraken';

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'PatientId',
        'MedewerkerId',
        'Datum',
        'Tijd',
        'Status',
        'Isactief',
        'Opmerking',
    ];

    // Haalt het aantal afspraken op uit de database
    
    public static function getAfsprakenCount()
    {
        try {
            $result = DB::select('CALL sp_GetAfsprakenCount()');

            return $result[0]->AfsprakenCount ?? 0;
        } catch (\Exception $e) {
            Log::error('Fout in getAfsprakenCount: '.$e->getMessage());

            return 0;
        }
    }
}
