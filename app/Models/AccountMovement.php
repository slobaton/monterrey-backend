<?php

namespace App\Models;

use App\Enums\AccountMovementType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class AccountMovement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'wash_order_id',
        'receipt_number',
        'date',
        'concept',
        'type',
        'amount'
    ];

    protected $casts = [
        'amount' => 'real',
    ];

    public function washOrder(): BelongsTo
    {
        return $this->belongsTo(WashOrder::class, 'wash_order_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public static function addCharge(WashOrder $washOrder, $amount): bool
    {
        $accountMovement = new AccountMovement();
        $accountMovement->client_id = $washOrder->client_id;
        $accountMovement->wash_order_id = $washOrder->id;
        $accountMovement->date = $washOrder->date;
        $accountMovement->concept = 'Orden de Lavado';
        $accountMovement->type = AccountMovementType::CHARGE->value;
        $accountMovement->amount = $amount;

        return $accountMovement->save();
    }

    public static function addPayment(Client $client, $receiptNumber, $amount, $date): bool
    {
        $accountMovement = new AccountMovement();
        $accountMovement->client_id = $client->id;
        $accountMovement->receipt_number = $receiptNumber;
        $accountMovement->date = $date;
        $accountMovement->concept = 'Pago a Cuenta';
        $accountMovement->type = AccountMovementType::PAYMENT->value;
        $accountMovement->amount = -$amount;

        return $accountMovement->save();
    }

    public static function addDiscount(Client $client, $concept, $amount, $date): bool
    {
        $accountMovement = new AccountMovement();
        $accountMovement->client_id = $client->id;
        $accountMovement->date = $date;
        $accountMovement->concept = $concept;
        $accountMovement->type = AccountMovementType::DISCOUNT->value;
        $accountMovement->amount = -$amount;

        return $accountMovement->save();
    }

    public static function getBalanceDebtUntilDate($date, $clientId): float
    {
        $data = DB::table('account_movements')
            ->where('client_id', $clientId)
            ->whereDate('date', '<', $date)
            ->sum('amount');

        return $data;
    }

    public static function getAccountMovementsByDate($month, $year, $clientId)
    {
        $data = DB::table('account_movements', 'ac')
            ->select(['ac.wash_order_id', 'wash_orders.code', 'ac.date', 'ac.type', 'ac.amount', 'ac.created_at', 'ac.updated_at'])
            ->join('wash_orders', 'ac.wash_order_id', '=', 'wash_orders.id')
            ->where('ac.client_id', $clientId)
            ->whereMonth('ac.date', $month)
            ->whereYear('ac.date', $year)
            ->orderBy('ac.date')
            ->orderBy('ac.type')
            ->get();

        return $data;
    }

    public static function getAccountMovements($clientId)
    {
        $query = DB::table('account_movements', 'ac')
            ->select(['ac.id', 'ac.client_id', 'ac.wash_order_id', 'wash_orders.code', 'ac.date', 'ac.type', 'ac.amount', 'ac.created_at', 'ac.updated_at'])
            ->join('wash_orders', 'ac.wash_order_id', '=', 'wash_orders.id');

        if (!is_null($clientId)) {
            $query = $query->where('ac.client_id', $clientId);
        }

        $data = $query->orderBy('ac.date')
            ->orderBy('ac.type')
            ->get();

        return $data;
    }
}
