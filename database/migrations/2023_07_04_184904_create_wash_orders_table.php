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
        Schema::create('wash_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('client_id');
            $table->unsignedBigInteger('wash_type_id');

            $table->bigInteger('code')->unique();
            $table->date('date');

            $table->decimal('wash_price', 10, 2)
                ->unsigned()
                ->nullable();

            $table->decimal('focalizado_price', 10, 2)
                ->unsigned()
                ->nullable();

            $table->decimal('nevado_price', 10, 2)
                ->unsigned()
                ->nullable();

            $table->integer('total_quantity');
            $table->decimal('total_price', 10, 2)
                ->unsigned();

            $table->integer('deliver_quantity')
                ->nullable();
            $table->datetime('deliver_date')
                ->nullable();

            $table->text('observations')
                ->nullable();

            $table->boolean('is_special_price');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients');
            $table->foreign('wash_type_id')
                ->references('id')
                ->on('wash_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wash_orders');
    }
};
