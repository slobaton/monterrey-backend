<?php

namespace App\Models;

use App\Enums\AccountMovementType;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Date;
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

    private static $monthNames = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

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

    public static function addDiscount(Client $client, $receiptNumber, $concept, $amount, $date): bool
    {
        $accountMovement = new AccountMovement();
        $accountMovement->client_id = $client->id;
        $accountMovement->receipt_number = $receiptNumber;
        $accountMovement->date = $date;
        $accountMovement->concept = $concept;
        $accountMovement->type = AccountMovementType::DISCOUNT->value;
        $accountMovement->amount = -$amount;

        return $accountMovement->save();
    }

    public static function getBalanceUntilDate($clientId, $date)
    {
        $balance = DB::table('account_movements')
            ->where('client_id', $clientId)
            ->where('date', '<', $date)
            ->sum('amount');

        return $balance ?? 0;
    }

    public static function getAccountMovements($clientId, $startDate = null, $endDate = null)
    {
        $query = DB::table('account_movements', 'ac')
            ->select([
                'ac.*',
                'wash_orders.code'
            ])
            ->leftJoin('wash_orders', 'ac.wash_order_id', '=', 'wash_orders.id')
            ->where('ac.client_id', $clientId);

        if (!is_null($startDate)) {
            $rangeDates = [$startDate, $endDate ?? Date::now()];

            $query = $query->whereBetween('ac.date', $rangeDates);
        }

        $data = $query->orderBy('ac.date')
            ->orderBy('ac.created_at')
            ->get();

        return $data;
    }

    public static function getDetailedMovements($movements, &$balance)
    {
        $accountMovements = $movements->map(function ($movement, int $key) use (&$balance) {
            $balanceDebt = $balance + $movement->amount;

            $accountMovement = [
                'id' => $movement->id,
                'client_id' => $movement->client_id,
                'receipt_number' => $movement->receipt_number,
                'date' => $movement->date,
                'concept' => $movement->concept,
                'type' => $movement->type,
                'code' => $movement->code,
                'wash_order_id' => $movement->wash_order_id,
                'amount' => (float)$movement->amount,
                'details' => $movement->type == AccountMovementType::CHARGE->value
                    ? WashOrderDetail::getDetailsByOrderId($movement->wash_order_id, $balance)
                    : null,
                'balance_debt' => $balanceDebt
            ];

            $balance = $balanceDebt;

            return $accountMovement;
        });

        return $accountMovements;
    }

    public static function getProcessedMovements($movements)
    {
        $processedDetails = AccountMovement::getProcessedDetails($movements);

        $groupedItems = $processedDetails->reduce(function ($prev, $current) {
            $date = new DateTime($current['date']);
            $month = $date->format('n');
            $year = $date->format('Y');

            $key = "Mes de " . AccountMovement::$monthNames[$month - 1] . " del " . $year;

            if (!isset($prev[$key])) {
                $prev[$key] = [];
            }

            $prev[$key][] = $current;

            return $prev;
        }, []);

        $months = array_keys($groupedItems);

        $processedMovements = [];
        $balancePrevMonth = 0;

        foreach ($months as $month) {
            $items = $groupedItems[$month] ?? [];

            $processedMovements[] = [
                'monthHeader' => $month,
                'monthBalanceDebt' => $balancePrevMonth,
                'monthItems' => $items
            ];

            $balancePrevMonth = end($items)['balance_debt'] ?? 0;
        }

        return $processedMovements;
    }

    public static function getAccountMovementsStartDate($clientId)
    {
        $startDate = DB::table('account_movements')
            ->where('client_id', $clientId)
            ->orderBy('date')
            ->orderBy('created_at')
            ->first('date');

        return $startDate?->date;
    }

    public static function getAccountMovementsEndDate($clientId)
    {
        $startDate = DB::table('account_movements')
            ->where('client_id', $clientId)
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->first('date');

        return $startDate?->date;
    }

    private static function getProcessedDetails($movements)
    {
        $processedDetails = collect();

        foreach ($movements as $movement) {
            if ($movement['details'] && count($movement['details']) > 0) {
                $movementDetails = collect($movement['details']);
                $processedDetail = $movementDetails->map(function ($movementDetail) use ($movement) {
                    return [
                        'id' => $movement['id'],
                        'code' => $movement['code'],
                        'date' => $movement['date'],
                        'receipt_number' => null,
                        'cloth_type' => $movementDetail['cloth_type'],
                        'cloth_size' => $movementDetail['cloth_size'],
                        'description' => $movementDetail['details'],
                        'unit_price' => $movementDetail['unit_price'],
                        'quantity' => $movementDetail['quantity'],
                        'subtotal_price' => $movementDetail['subtotal_price'],
                        'amount' => null,
                        'balance_debt' => $movementDetail['balance_debt'],
                        'type' => $movement['type']
                    ];
                });

                $processedDetails = $processedDetails->merge($processedDetail);
            } else {
                $processedDetails[] = [
                    'id' => $movement['id'],
                    'code' => null,
                    'date' => $movement['date'],
                    'receipt_number' => $movement['receipt_number'],
                    'cloth_type' => null,
                    'cloth_size' => null,
                    'description' => $movement['concept'],
                    'unit_price' => null,
                    'quantity' => null,
                    'subtotal_price' => null,
                    'amount' => abs($movement['amount']),
                    'balance_debt' => $movement['balance_debt'],
                    'type' => $movement['type']
                ];
            }
        }

        return $processedDetails;
    }
}
