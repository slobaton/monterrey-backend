<?php

namespace App\Rules;

use Closure;
use App\Models\IncomeReceipt;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidCancelableIncomeReceiptRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validReceiptNumber = IncomeReceipt::getNextConsecutive();

        if (!IncomeReceipt::verifyCancelableNumber($value)) {
            $fail("El número de recibo no es válido para ser anulado. Debe ser nuevo y consecutivo. Sig Num: $validReceiptNumber");
        }
    }
}
