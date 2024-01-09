<?php

use App\Enums\AccountMovement;
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
            $table->uuid('wash_order_id');

            $table->date('date');

            $table->enum('type', [AccountMovement::CHARGE->value, AccountMovement::PAYMENT->value])
                ->default(AccountMovement::CHARGE->value);

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
