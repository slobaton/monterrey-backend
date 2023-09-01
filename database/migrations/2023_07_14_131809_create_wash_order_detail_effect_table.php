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
        Schema::create('wash_order_detail_effect', function (Blueprint $table) {
            $table->id();
            $table->uuid('wash_order_detail_id');
            $table->uuid('effect_id');
            $table->decimal('price', 10, 2)
                ->unsigned();

            $table->timestamps();

            $table->foreign('effect_id')
                ->references('id')
                ->on('effects');
            $table->foreign('wash_order_detail_id')
                ->references('id')
                ->on('wash_order_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wash_order_detail_effect');
    }
};
