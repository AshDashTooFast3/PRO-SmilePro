<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Gebruiker', function (Blueprint $table) {
            $table->id();
            $table->string('Gebruikersnaam')->unique();
            $table->string('Wachtwoord');
            $table->string('Email');
            $table->string('RolNaam', 20)->nullable(false);
            $table->timestamp('Ingelogd')->nullable();
            $table->timestamp('Uitgelogd')->nullable();
            $table->boolean('Isactief')->default(true);
            $table->string('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->useCurrent();
            $table->timestamp('Datumgewijzigd')->useCurrent();
            $table->rememberToken();
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
