<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'month' => 'required|integer|between:1,12',
            'year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
        ]);

        $month = $request->month;
        $year = $request->year;

        $monthlyIncomeDetail = Income::getDetailedIncomeByMonth($month, $year);

        return $this->respondWithSuccess($monthlyIncomeDetail);
    }
}
