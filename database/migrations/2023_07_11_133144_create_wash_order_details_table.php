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
        Schema::create('wash_order_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreign('wash_order_id')
                ->references('id')
                ->on('wash_orders');
            $table->foreign('cloth_type_id')
                ->references('id')
                ->on('cloth_types');
            $table->foreign('cloth_size_id')
                ->references('id')
                ->on('cloth_types');
            $table->boolean('is_special_wash')->default(false);
            $table->decimal('wash_price', 10, 2)->nullable();
            $table->decimal('effect_price', 10, 2)->nullable();
            $table->integer('num_buttonholes')->default(0);
            $table->decimal('additional_price', 10, 2)->nullable();
            $table->decimal('additional_price_desc', 10, 2)->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('sub_total_price', 20, 2)->nullable();
            $table->text('observations');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wash_order_details');
    }
};
