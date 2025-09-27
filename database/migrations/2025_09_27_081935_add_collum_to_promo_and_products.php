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
        Schema::table('promo_periods', function (Blueprint $table) {
            $table->string('image')
                  ->default('client/img/promo/default.jpg')
                  ->after('end_date');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->decimal('purchase_price', 10, 2)
                  ->nullable()
                  ->after('price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promo_periods', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('purchase_price');
        });
    }
};
