<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class Factuur extends Model
{
    use HasFactory;

    protected $table = 'Factuur';

    protected $primaryKey = 'Id';

    public $timestamps = false;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'PatientId',
        'BehandelingId',
        'Nummer',
        'Datum',
        'Bedrag',
        'Status',
        'Isactief',
        'Opmerking',
        'Datumaangemaakt',
        'Datumgewijzigd',
    ];

    public static function getAllFacturen()
    {
        return DB::select('CALL sp_GetAllFactuur()');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId', 'Id');
    }

    public function behandeling()
    {
        return $this->belongsTo(Behandeling::class, 'BehandelingId', 'Id');
    }

    /*Probeert om de sp_OmzetBerekenen in de database aan te roepen, 
    anders geeft hij een error en stuurt hij een lege array terug en logt de error in storage/logs/laravel.log
    */

    public function BerekenOmzet()
    {
        try {
            $result = DB::select('CALL sp_OmzetBerekenen()');

            if ($result === null) {
                Log::warning('sp_OmzetBerekenen retourneerde null.');
                return [];
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('Fout in BerekenOmzet: '.$e->getMessage());
            return [];
        }
    }
}
