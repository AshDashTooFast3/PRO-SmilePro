<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Gebruiker', function (Blueprint $table) {
            $table->increments('Id');
            $table->string('Gebruikersnaam', 50);
            $table->string('Wachtwoord', 100);
            $table->string('RolNaam', 50);
            $table->string('Email', 100)->unique();
            $table->dateTime('Ingelogd')->nullable();
            $table->dateTime('Uitgelogd')->nullable();
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('Email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('Persoon', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('GebruikerId');
            $table->string('Voornaam', 50);
            $table->string('Tussenvoegsel', 20)->nullable();
            $table->string('Achternaam', 50);
            $table->date('Geboortedatum');
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('GebruikerId')->references('Id')->on('Gebruiker');
        });

        Schema::create('Patient', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PersoonId');
            $table->string('Nummer', 20);
            $table->string('MedischDossier', 255)->nullable();
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PersoonId')->references('Id')->on('Persoon');
        });

        Schema::create('Medewerker', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PersoonId');
            $table->string('Nummer', 20);
            $table->enum('Medewerkertype', ['Assistent', 'Mondhygiënist', 'Tandarts', 'Praktijkmanagement']);
            $table->string('Specialisatie', 100)->nullable();
            $table->string('Beschikbaarheid', 20)->nullable();
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PersoonId')->references('Id')->on('Persoon');
        });

        Schema::create('Beschikbaarheid', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('MedewerkerId');
            $table->date('Datumvanaf');
            $table->date('Datumtotmet');
            $table->time('Tijdvanaf');
            $table->time('Tijdtotmet');
            $table->enum('Status', ['Aanwezig', 'Afwezig', 'Verlof', 'Ziek']);
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('MedewerkerId')->references('Id')->on('Medewerker');
        });

        Schema::create('Contact', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PatientId');
            $table->string('Straatnaam', 100);
            $table->string('Huisnummer', 10);
            $table->string('Toevoeging', 10)->nullable();
            $table->string('Postcode', 10);
            $table->string('Plaats', 50);
            $table->string('Mobiel', 20)->nullable();
            $table->string('Email', 100)->nullable();
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PatientId')->references('Id')->on('Patient');
        });

        Schema::create('Afspraken', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PatientId');
            $table->unsignedInteger('MedewerkerId');
            $table->date('Datum');
            $table->time('Tijd');
            $table->enum('Status', ['Bevestigd', 'Geannuleerd']);
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PatientId')->references('Id')->on('Patient');
            $table->foreign('MedewerkerId')->references('Id')->on('Medewerker');
        });

        Schema::create('Behandeling', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('MedewerkerId');
            $table->unsignedInteger('PatientId');
            $table->date('Datum');
            $table->time('Tijd');
            $table->enum('Behandelingtype', ['Controles', 'Vullingen', 'Gebitsreiniging', 'Orthodontie', 'Wortelkanaalbehandelingen']);
            $table->string('Omschrijving', 255)->nullable();
            $table->decimal('Kosten', 10, 2);
            $table->enum('Status', ['Behandeld', 'Onbehandeld', 'Uitgesteld']);
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('MedewerkerId')->references('Id')->on('Medewerker');
            $table->foreign('PatientId')->references('Id')->on('Patient');
        });

        Schema::create('Factuur', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PatientId');
            $table->unsignedInteger('BehandelingId');
            $table->string('Nummer', 20);
            $table->date('Datum');
            $table->decimal('Bedrag', 10, 2);
            $table->enum('Status', ['Verzonden', 'Niet-Verzonden', 'Betaald', 'Onbetaald']);
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PatientId')->references('Id')->on('Patient');
            $table->foreign('BehandelingId')->references('Id')->on('Behandeling');
        });

        Schema::create('Communicatie', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PatientId');
            $table->unsignedInteger('MedewerkerId');
            $table->string('Bericht', 255);
            $table->dateTime('VerzondenDatum');
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->nullable()->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PatientId')->references('Id')->on('Patient');
            $table->foreign('MedewerkerId')->references('Id')->on('Medewerker');
        });

        Schema::create('Feedback', function (Blueprint $table) {
            $table->increments('Id');
            $table->unsignedInteger('PatientId');
            $table->integer('Beoordeling');
            $table->string('praktijkEmail', 100)->nullable();
            $table->string('praktijkTelefoon', 20)->nullable();
            $table->boolean('Isactief');
            $table->string('Opmerking', 255)->nullable();
            $table->dateTime('Datumaangemaakt', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->dateTime('Datumgewijzigd', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreign('PatientId')->references('Id')->on('Patient');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Feedback');
        Schema::dropIfExists('Communicatie');
        Schema::dropIfExists('Factuur');
        Schema::dropIfExists('Behandeling');
        Schema::dropIfExists('Afspraken');
        Schema::dropIfExists('Contact');
        Schema::dropIfExists('Beschikbaarheid');
        Schema::dropIfExists('Medewerker');
        Schema::dropIfExists('Patient');
        Schema::dropIfExists('Persoon');
        Schema::dropIfExists('Gebruiker');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
    }
};
