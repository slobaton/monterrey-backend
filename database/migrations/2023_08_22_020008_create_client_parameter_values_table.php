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
        Schema::create('client_parameter_values', function (Blueprint $table) {
            $table->id();

            $table->decimal('value', 10, 2);

            $table->timestamps();

            $table->foreignId('system_parameter_id')
                ->references('id')
                ->on('system_parameters');

            $table->foreignUuid('client_id')
                ->references('id')
                ->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_parameter_values');
    }
};
