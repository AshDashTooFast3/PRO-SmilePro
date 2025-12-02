<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Afspraken extends Model
{
    use HasFactory;
    protected $table = "Afspraken";

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'PatientId',
        'MedewerkerId',
        'Datum',
        'Tijd',
        'Status',
        'Isactief',
        'Opmerking'
    ];

    public function getAfsprakenCount() {
        return DB::select('CALL sp_GetAfsprakenCount()')[0]->AfsprakenCount ?? 0;
    }
}
