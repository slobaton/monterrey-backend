<?php

use App\Enums\AccountMovementType;
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
        Schema::create('account_movements', function (Blueprint $table) {
            $table->id();

            $table->uuid('client_id');
            $table->uuid('wash_order_id')
                ->nullable();

            $table->bigInteger('receipt_number')
                ->unsigned()
                ->unique();
            $table->date('date');
            $table->string('concept', 150);
            $table->enum('type', [AccountMovementType::CHARGE->value, AccountMovementType::PAYMENT->value, AccountMovementType::DISCOUNT->value])
                ->default(AccountMovementType::CHARGE->value);
            $table->decimal('amount', 10, 2);

            $table->timestamps();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients');

            $table->foreign('wash_order_id')
                ->references('id')
                ->on('wash_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_movements');
    }
};
