<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('full_name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->boolean('available')->default(true);
            $table->foreignId('main_category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->decimal('discount', 10, 2)->nullable();
            $table->date('discount_end_date')->nullable();
            $table->decimal('deal', 10, 2)->nullable();
            $table->boolean('luxury')->default(false);
            $table->boolean('is_coming')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->enum('status', ['new', 'active', 'archived'])->default('new');
            $table->string('promo_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
