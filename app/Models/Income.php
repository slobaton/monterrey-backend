<?php

namespace App\Models;

use App\Enums\IncomeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'receipt_number',
        'date',
        'concept',
        'type',
        'amount'
    ];

    protected $casts = [
        'amount' => 'real',
    ];

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(IncomeReceipt::class, 'receipt_number', 'id');
    }

    public static function addIncome($receiptNumber, $concept, $type, $amount, $date): bool
    {
        $income = new Income();
        $income->receipt_number = $receiptNumber;
        $income->date = $date;
        $income->concept = $concept;
        $income->type = $type;
        $income->amount = $amount;

        return $income->save();
    }

    public static function getMonthlyIncomes($month, $year)
    {
        return Income::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->orderBy('created_at')
            ->get();
    }

    public static function getDetailedIncomeByMonth($month, $year)
    {
        $monthlyIncomes = Income::getMonthlyIncomes($month, $year);
        $totalRealIncome = 0;
        $totalIncome = 0;

        $monthlyIncomes = $monthlyIncomes->map(function ($income, int $key) use (&$totalRealIncome, &$totalIncome) {
            $incomeSubTotal = $totalIncome + (float)$income->amount;
            $income->sub_total = $incomeSubTotal;

            $totalIncome = $incomeSubTotal;
            $totalRealIncome = $income->type == IncomeType::NORMAL->value
                ? $totalRealIncome + (float)$income->amount
                : $totalRealIncome;

            return $income;
        });

        return [
            'total_income' => $totalIncome,
            'total_real_income' => $totalRealIncome,
            'incomes' => $monthlyIncomes,
        ];
    }
}
