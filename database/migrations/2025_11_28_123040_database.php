<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            CREATE TABLE Gebruiker (
                Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
                ,Gebruikersnaam VARCHAR(50) NOT NULL
                ,Wachtwoord VARCHAR(100) NOT NULL
                ,RolNaam VARCHAR(50) NOT NULL
                ,Ingelogd DATETIME NOT NULL
                ,Uitgelogd DATETIME NOT NULL
                ,Isactief BIT NOT NULL
                ,Opmerking VARCHAR(255) NULL
                ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
                ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
            );
        ");

                DB::unprepared("
            CREATE TABLE Gebruiker2 (
                Id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
                ,Gebruikersnaam VARCHAR(50) NOT NULL
                ,Wachtwoord VARCHAR(100) NOT NULL
                ,RolNaam VARCHAR(50) NOT NULL
                ,Ingelogd DATETIME NOT NULL
                ,Uitgelogd DATETIME NOT NULL
                ,Isactief BIT NOT NULL
                ,Opmerking VARCHAR(255) NULL
                ,Datumaangemaakt DATETIME(6) NOT NULL DEFAULT NOW(6)
                ,Datumgewijzigd DATETIME(6) NULL DEFAULT NOW(6)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Gebruiker');
        Schema::dropIfExists('Gebruiker2');
    }
};
