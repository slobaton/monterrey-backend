<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\CancelIncomeReceiptRequest;
use App\Models\IncomeReceipt;

class IncomeReceiptController extends Controller
{
    /**
     * Add payment movement for the client.
     */
    public function cancelReceipt(CancelIncomeReceiptRequest $request)
    {
        $userId = $request->user()->id;
        $receiptNumber = $request->get('receipt_number');
        $canceledReason = $request->get('canceled_reason');
        $date = $request->get('date', Date::now()->toDateString());

        $date = Date::parse($date);

        $receiptCanceled = IncomeReceipt::cancelReceipt($receiptNumber, $canceledReason, $date, $userId);

        if (!$receiptCanceled) {
            return $this->respondError("cannot cancel the income receipt.");
        }

        return $this->respondWithSuccess();
    }
}
