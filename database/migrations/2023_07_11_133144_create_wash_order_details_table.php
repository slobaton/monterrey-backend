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

            $table->uuid('wash_order_id');
            $table->unsignedBigInteger('cloth_type_id');
            $table->unsignedBigInteger('cloth_size_id');

            $table->decimal('wash_price', 10, 2)
                ->unsigned();

            $table->decimal('effect_price', 10, 2)
                ->unsigned()
                ->nullable();

            $table->boolean('is_focalizado_active')
                ->default(false);
            $table->decimal('focalizado_price', 10, 2)
                ->unsigned()
                ->nullable();

            $table->boolean('is_nevado_active')
                ->default(false);
            $table->decimal('nevado_price', 10, 2)
                ->unsigned()
                ->nullable();

            $table->integer('num_buttonholes')
                ->default(0);

            $table->integer('min_buttonholes')
                ->default(0);
            $table->decimal('buttonhole_unit_price', 10, 2)
                ->unsigned()
                ->default(0);

            $table->decimal('buttonholes_price', 10, 2)
                ->unsigned()
                ->default(0);

            $table->decimal('unit_price', 10, 2)
                ->unsigned();
            $table->integer('quantity');
            $table->decimal('subtotal_price', 14, 2)
                ->unsigned();

            $table->text('observations')->nullable();

            $table->timestamps();

            $table->foreign('wash_order_id')
                ->references('id')
                ->on('wash_orders');
            $table->foreign('cloth_type_id')
                ->references('id')
                ->on('cloth_types');
            $table->foreign('cloth_size_id')
                ->references('id')
                ->on('cloth_sizes');
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
