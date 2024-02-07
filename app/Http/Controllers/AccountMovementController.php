<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountMovement;
use App\Models\WashOrderDetail;
use App\Enums\AccountMovementType;

class AccountMovementController extends Controller
{
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
