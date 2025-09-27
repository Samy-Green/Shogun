<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_periods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nom de la période promo, ex: "Soldes de Noël"
            $table->text('description')->nullable(); // description de la période
            $table->date('start_date'); // date de début
            $table->date('end_date'); // date de fin
            $table->boolean('is_active')->default(true); // activer ou désactiver la période
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_periods');
    }
};
