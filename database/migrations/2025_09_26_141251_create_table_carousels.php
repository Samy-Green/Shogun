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
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('title');              // Titre de l'élément
            $table->text('description')->nullable(); // Description de l'élément
            $table->string('button_icon')->nullable(); // Icône du bouton (texte)
            $table->string('button_text')->nullable(); // Texte du bouton
            $table->string('button_link')->nullable(); // Lien du bouton
            $table->string('image')->nullable(); // Lien de l'image
            $table->timestamps();                 // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousels');
    }
};
