<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Afspraak extends Model
{
    use HasFactory;

    protected $table = 'Afspraken';
    protected $primaryKey = 'Id';
    public $timestamps = false;

    protected $fillable = [
        'PatientId',
        'MedewerkerId',
        'Datum',
        'Tijd',
        'Status',
        'Isactief',
        'Opmerking',
    ];

    // Optioneel, maar veilig
    protected $casts = [
        'Datum' => 'date',
        'Isactief' => 'boolean',
    ];

    // CODE VAN JE VRIEND - NIET AANKOMEN
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

    // Relaties
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId', 'Id');
    }

    public function medewerker()
    {
        return $this->belongsTo(Medewerker::class, 'MedewerkerId', 'Id');
    }

    // Veilige extra helpers
    public function isActief()
    {
        return $this->Isactief == 1;
    }

    public function isBevestigd()
    {
        return $this->Status === 'Bevestigd';
    }

    public function isGeannuleerd()
    {
        return $this->Status === 'Geannuleerd';
    }

    // Veilige scope
    public function scopeActief($query)
    {
        return $query->where('Isactief', 1);
    }
}