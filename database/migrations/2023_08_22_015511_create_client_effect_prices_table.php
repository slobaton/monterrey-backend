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
        Schema::create('client_effect_prices', function (Blueprint $table) {
            $table->id();

            $table->decimal('price', 10, 2);

            $table->timestamps();

            $table->foreignUuid('effect_id')->references('id')->on('effects');
            $table->foreignUuid('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_effect_prices');
    }
};
