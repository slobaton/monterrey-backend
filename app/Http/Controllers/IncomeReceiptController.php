<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeReceipt;
use Illuminate\Support\Facades\Date;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\CancelIncomeReceiptRequest;
use App\Http\Resources\IncomeReceiptCollection;

class IncomeReceiptController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): IncomeReceiptCollection
    {
        $incomeReceipts = QueryBuilder::for(IncomeReceipt::class)
            ->allowedFilters(IncomeReceipt::getAllowedFilters())
            ->defaultSort(IncomeReceipt::getDefaultSort())
            ->allowedSorts(IncomeReceipt::getAllowedSorts())
            ->allowedIncludes(IncomeReceipt::getAllowedIncludes());

        $incomeReceipts = $request->has('page.number') && $request->has('page.size')
            ? $incomeReceipts->jsonPaginate()
            : $incomeReceipts->get();

        return new IncomeReceiptCollection($incomeReceipts);
    }

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
