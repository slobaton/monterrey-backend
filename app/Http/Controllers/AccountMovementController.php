<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountMovement;
use App\Models\WashOrderDetail;
use App\Enums\AccountMovementType;

class AccountMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getMovements(Request $request)
    {
        $clientId = $request->query('clientId', null);

        $movements = AccountMovement::getAccountMovements($clientId);

        $balance = 0;

        $accountMovements = $movements->map(function ($movement, int $key) use (&$balance) {
            $balanceDebt = $balance + $movement->amount;

            $accountMovement = [
                'id' => $movement->id,
                'client_id' => $movement->client_id,
                'date' => $movement->date,
                'code' => $movement->code,
                'type' => $movement->type,
                'wash_order_id' => $movement->wash_order_id,
                'amount' => (float)$movement->amount,
                'balance_debt' => $balanceDebt
            ];

            $balance = $balanceDebt;

            return $accountMovement;
        });

        $data = [
            'start_balance' => 0,
            'final_balance' => $balance,
            'movements' => $accountMovements,
        ];

        return $this->respondWithSuccess($data);
    }

    /**
     * Retrieve account movement information
     */
    public function getMovementById(Request $request, AccountMovement $movement)
    {
        $washOrder = $movement->washOrder;
        $client = $movement->client;

        $accountMovement = [
            'date' => $movement->date,
            'code' => $washOrder->code,
            'type' => $movement->type,
            'client_id' => $client->id,
            'client' => $client,
            'wash_order_id' => $movement->wash_order_id,
            'amount' => (float)$movement->amount,
            'details' => $movement->type == AccountMovementType::CHARGE->value
                ? WashOrderDetail::getDetailsByOrderId($movement->wash_order_id, 0)
                : null,
            'balance_debt' => null
        ];

        return $this->respondWithSuccess($accountMovement);
    }
}
