<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_getVolledigeNaamPatienten');

        DB::unprepared("
        CREATE PROCEDURE sp_getVolledigeNaamPatienten()
        BEGIN
            SELECT 
                pa.Id AS PatientId,
                pa.PersoonId,
                pa.Nummer,
                pa.MedischDossier,
                pa.Isactief,
                pa.Opmerking,
                pa.Datumaangemaakt,
                pa.Datumgewijzigd,
                CONCAT_WS(' ', p.Voornaam, p.Tussenvoegsel, p.Achternaam) AS Naam
            FROM Patient pa
            JOIN Persoon p ON pa.PersoonId = p.Id;
        END
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
