<?php

use App\Enums\IncomeReceiptStatus;
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
        Schema::create('income_receipts', function (Blueprint $table) {
            $table->bigInteger('id')
                ->unsigned()
                ->primary();

            $table->date('date');
            $table->enum('status', [IncomeReceiptStatus::ACTIVE->value, IncomeReceiptStatus::CANCELED->value])
                ->default(IncomeReceiptStatus::ACTIVE->value);
            $table->text('canceled_reason')
                ->nullable();

            $table->foreignUuid('user_id')
                ->references('id')
                ->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_receipts');
    }
};
