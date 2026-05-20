<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_product_id')->constrained('batch_products')->cascadeOnDelete();
            $table->unsignedInteger('qty');
            $table->date('refunded_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_refunds');
    }
};
