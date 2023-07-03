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
        Schema::create('cloth_sizes', function (Blueprint $table) {
            $table->id();

            $table->string('name')
                ->unique();
            $table->text('description')
                ->nullable();
            $table->decimal('wash_price', 10, 2)
                ->unsigned();
            $table->decimal('wash_special_price', 10, 2)
                ->unsigned()
                ->nullable();
            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cloth_sizes');
    }
};
