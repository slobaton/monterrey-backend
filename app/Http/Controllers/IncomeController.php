<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Http\Requests\AddIncomeRequest;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'month' => 'sometimes|nullable|integer|between:1,12',
            'year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
        ]);

        $month = $request->month;
        $year = $request->year;

        $detailesIncomes = Income::getDetailedIncomes($month, $year);

        return $this->respondWithSuccess($detailesIncomes);
    }

    /**
     * Add other income.
     */
    public function store(AddIncomeRequest $request)
    {
        $userId = $request->user()->id;
        $receiptNumber = $request->get('receipt_number');
        $concept = $request->get('concept');
        $amount = $request->get('amount', 0);
        $clientName = $request->get('client_name');

        $date = $request->get('date', Date::now()->toDateString());
        $date = Date::parse($date);

        $incomeAdded = Income::registerIncomeProcess($receiptNumber, $concept, $amount, $date, $userId, $clientName);

        if (!$incomeAdded) {
            return $this->respondError('cannot add income');
        }

        return $this->respondWithSuccess();
    }
}
