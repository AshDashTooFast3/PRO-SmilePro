<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

const CREATED_AT = 'Datumaangemaakt';
const UPDATED_AT = 'Datumgewijzigd';

class Behandeling extends Model
{
    /** @use HasFactory<\Database\Factories\BehandelingFactory> */
    use HasFactory;

    protected $table = 'Behandeling';

    const CREATED_AT = 'Datumaangemaakt';

    const UPDATED_AT = 'Datumgewijzigd';
}
