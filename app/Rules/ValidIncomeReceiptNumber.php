<?php

namespace App\Rules;

use App\Models\IncomeReceipt;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIncomeReceiptNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!IncomeReceipt::verifyNumber($value)) {
            $validReceiptNumber = IncomeReceipt::getNextConsecutive();
            $fail("El número de recibo es inválido. Debe ser consecutivo o existente. Sig Num: $validReceiptNumber");
        }
    }
}
