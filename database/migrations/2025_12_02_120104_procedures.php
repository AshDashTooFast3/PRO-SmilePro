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
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAfsprakenCount');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllBerichten');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_OmzetBerekenen');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_GetAllFactuur');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_DeleteBericht');
        
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

        DB::unprepared('
        DROP PROCEDURE IF EXISTS sp_GetAfsprakenCount;
        CREATE PROCEDURE sp_GetAfsprakenCount()
        BEGIN
            SELECT COUNT(*) AS AfsprakenCount
            FROM Afspraken;
        END;
    ');
        DB::unprepared('
        DROP PROCEDURE IF EXISTS sp_OmzetBerekenen;

        CREATE PROCEDURE sp_OmzetBerekenen()

        BEGIN
            
        SELECT SUM(Bedrag) AS TotaleOmzet

            FROM Factuur
            WHERE Status = \'Betaald\';

        END;
');

        DB::unprepared('
            CREATE PROCEDURE sp_GetAllFactuur()
            BEGIN
                SELECT 
                    persoon.Voornaam AS PatientVoornaam, 
                    persoon.Tussenvoegsel AS PatientTussenvoegsel,
                    persoon.Achternaam AS PatientAchternaam, 
                    b.Behandelingtype AS BehandelingType,
                    f.Id,
                    f.PatientId,
                    f.BehandelingId,
                    f.Nummer, 
                    f.Omschrijving,
                    f.Datum,
                    f.Tijd, 
                    f.Status,
                    f.Bedrag, 
                    f.Isactief
                FROM Factuur f
                INNER JOIN Patient p ON f.PatientId = p.Id
                INNER JOIN Persoon persoon ON p.PersoonId = persoon.Id
                INNER JOIN Behandeling b ON f.BehandelingId = b.Id
                ORDER BY f.Datum DESC;
            END
        ');
    
    //Berichten stored procedures

        DB::unprepared('

        CREATE PROCEDURE sp_GetAllBerichten()
        BEGIN
            SELECT 
                COM.Id,
                COM.PatientId,
                COM.MedewerkerId,
                COM.Bericht,
                COM.VerzondenDatum,
                COM.Status,
                COM.Isactief,

                -- Patient info
                PAT.Nummer AS PatientNummer,
                PER_PAT.Voornaam AS PatientVoornaam,
                PER_PAT.Tussenvoegsel AS PatientTussenvoegsel,
                PER_PAT.Achternaam AS PatientAchternaam,

                -- Medewerker info
                MED.Nummer AS MedewerkerNummer,
                PER_MED.Voornaam AS MedewerkerVoornaam,
                PER_MED.Tussenvoegsel AS MedewerkerTussenvoegsel,
                PER_MED.Achternaam AS MedewerkerAchternaam

            FROM Communicatie COM
            
            INNER JOIN Medewerker MED ON COM.MedewerkerId = MED.Id
            INNER JOIN Persoon PER_MED ON MED.PersoonId = PER_MED.Id
            INNER JOIN Patient PAT ON COM.PatientId = PAT.Id
            INNER JOIN Persoon PER_PAT ON PAT.PersoonId = PER_PAT.Id;
        END;

        

    ');

        DB::unprepared('
        

        DROP PROCEDURE IF EXISTS sp_DeleteBericht;


        CREATE PROCEDURE sp_DeleteBericht (
            IN CommunicatieId INT
        )

        BEGIN
            DELETE FROM Communicatie c 
            WHERE Id = CommunicatieId;
        END

        ');

        DB::unprepared('
        
        DROP PROCEDURE IF EXISTS sp_WijzigBericht;

        CREATE PROCEDURE sp_WijzigBericht (
            IN CommunicatieId INT,
            IN PatientId INT,
            IN MedewerkerId INT,
            IN Bericht VARCHAR(255),
            IN Status ENUM(\'Betaald\', \'Onbetaald\', \'In behandeling\', \'Afgehandeld\')
        )

        BEGIN
            UPDATE Communicatie 
            SET 
                PatientId = PatientId,
                MedewerkerId = MedewerkerId,
                Bericht = Bericht,
                VerzondenDatum = NULL,
                Status = Status
            WHERE Id = CommunicatieId;
        END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
       
    }
};
