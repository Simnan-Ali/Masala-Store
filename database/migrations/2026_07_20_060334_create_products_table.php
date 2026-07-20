<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('sub_category_id')
                ->constrained('sub_categories')
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('sku')->unique();

            $table->decimal('purchase_price',10,2)->default(0);

            $table->decimal('mrp',10,2);

            $table->decimal('selling_price',10,2);

            $table->integer('stock')->default(0);

            $table->decimal('weight',8,2)->nullable();

            $table->string('unit')->default('Kg');

            $table->string('thumbnail')->nullable();

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            $table->boolean('featured')->default(false);

            $table->boolean('trending')->default(false);

            $table->boolean('status')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};