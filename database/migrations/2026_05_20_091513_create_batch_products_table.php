<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('batch_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained('batches')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete(); // TODO: index on product_id alone? lots of queries filter by it
            $table->unsignedInteger('qty');
            $table->decimal('unit_cost', 10, 2);
            $table->timestamps();

            $table->unique(['batch_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_products');
    }
};
