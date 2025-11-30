<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    public function persoon()
    {
        return $this->belongsTo(Persoon::class, 'PersoonId');
    }
}
