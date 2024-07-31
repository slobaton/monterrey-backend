<?php

namespace App\Rules;

use App\Models\IncomeReceipt;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIncomeReceiptNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validReceiptNumber = IncomeReceipt::getNextConsecutive();

        if (!IncomeReceipt::verifyNumber($value)) {
            $fail("El número de recibo es inválido. Debe ser consecutivo o existente. Sig Num: $validReceiptNumber");
        }

        $receipt = IncomeReceipt::find($validReceiptNumber);

        if (!is_null($receipt) && !$receipt->isActive()) {
            $fail("El número de recibo fue anulado. Debe ser un número de recibo libre o vigente. Sig Num: $validReceiptNumber");
        }
    }
}
