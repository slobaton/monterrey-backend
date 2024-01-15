<?php

namespace App\Http\Controllers;

use App\Enums\AccountMovementType;
use App\Models\AccountMovement;
use App\Models\WashOrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class AccountMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentDate = Date::now();

        $clientId = $request->query('clientId', null);
        $balanceMonth = $request->query('balanceMonth', $currentDate->month);
        $balanceYear = $request->query('balanceYear', $currentDate->year);

        $startBalanceDate = Carbon::createFromDate($balanceYear, $balanceMonth, 1);
        $startBalanceDebt = AccountMovement::getBalanceDebtUntilDate($startBalanceDate, $clientId);
        $movements = AccountMovement::getAccountMovementsByDate($balanceMonth, $balanceYear, $clientId);

        $balanceUntilDate = $startBalanceDebt;

        $accountMovements = $movements->map(function ($movement, int $key) use (&$balanceUntilDate) {
            $balanceDebt = $balanceUntilDate + $movement->amount;

            $accountMovement = [
                'date' => $movement->date,
                'code' => $movement->code,
                'type' => $movement->type,
                'wash_order_id' => $movement->wash_order_id,
                'amount' => (float)$movement->amount,
                'details' => $movement->type == AccountMovementType::CHARGE->value
                    ? WashOrderDetail::getDetailsByOrderId($movement->wash_order_id, $balanceUntilDate)
                    : null,
                'balance_debt' => $balanceDebt
            ];

            $balanceUntilDate = $balanceDebt;

            return $accountMovement;
        });

        $data = [
            'start_balance' => $startBalanceDebt,
            'movements' => $accountMovements
        ];

        return $this->respondWithSuccess($data);
    }
}
