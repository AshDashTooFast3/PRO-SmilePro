<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Medewerker', function (Blueprint $table) {
            $table->increments('Id'); // custom PK
            $table->integer('PersoonId');
            $table->string('Nummer');
            $table->string('Medewerkertype');
            $table->string('Specialisatie')->nullable();
            $table->string('Beschikbaarheid')->nullable();
            $table->boolean('Isactief')->default(true);
            $table->text('Opmerking')->nullable();
            $table->timestamp('Datumaangemaakt')->nullable();
            $table->timestamp('Datumgewijzigd')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Medewerker');
    }
};
