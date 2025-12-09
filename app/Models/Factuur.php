<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'PatientId', 'Id');
    }

    public function behandeling()
    {
        return $this->belongsTo(Behandeling::class, 'BehandelingId', 'Id');
    }

    public function BerekenOmzet()
    {
        DB::SELECT('CALL sp_OmzetBerekenen()');
    }
}

