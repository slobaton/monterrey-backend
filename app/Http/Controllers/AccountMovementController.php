<?php

namespace App\Http\Controllers;

use App\Enums\AccountMovementType;
use App\Models\AccountMovement;
use App\Models\WashOrderDetail;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class AccountMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientId = "fef65b68-6c47-3d2e-a3a8-687f1f4c0791";
        $date = Carbon::createFromDate(2024, 1, 1);
        $startBalance = AccountMovement::getBalanceDebtUntilDate($date, $clientId);
        $movements = AccountMovement::getAccountMovementsByDate(1, 2024, $clientId);

        $balanceUntilDate = $startBalance;

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
            'start_balance' => $startBalance,
            'movements' => $accountMovements
        ];

        return $this->respondWithSuccess($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountMovement $accountMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountMovement $accountMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountMovement $accountMovement)
    {
        //
    }
}
