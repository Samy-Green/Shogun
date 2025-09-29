<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cities table
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('delivery', ['shipping', 'home', 'none'])->default('shipping');
            $table->decimal('cost', 10, 2)->default(2000); // delivery cost
            $table->timestamps();
        });

        // Neighborhoods table
        Schema::create('neighborhoods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('cost', 10, 2)->default(1500); // additional cost if needed
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neighborhoods');
        Schema::dropIfExists('cities');
    }
};
