<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nom original du fichier
            $table->string('path'); // chemin de stockage (ex: storage/app/public/files/xxx.pdf)
            $table->string('mime_type')->nullable(); // type MIME (pdf, jpeg, etc.)
            $table->unsignedBigInteger('size')->nullable(); // taille en octets
            // $table->morphs('fileable'); // relation polymorphique (optionnel)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
