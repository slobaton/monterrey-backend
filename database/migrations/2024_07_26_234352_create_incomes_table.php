<?php

use App\Enums\IncomeType;
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
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id')
                ->unsigned();

            $table->date('date');

            $table->bigInteger('receipt_number')
                ->unsigned();

            $table->string('concept', 150);
            $table->enum('type', [IncomeType::NORMAL->value, IncomeType::WITHLOSS->value])
                ->default(IncomeType::NORMAL->value);

            $table->decimal('amount', 10, 2);

            $table->foreign('receipt_number')
                ->references('id')
                ->on('income_receipts');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
