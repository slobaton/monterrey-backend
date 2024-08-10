<?php

namespace App\Rules;

use App\Enums\IncomeReceiptStatus;
use App\Enums\IncomeType;
use App\Models\IncomeReceipt;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidIncomeReceiptNumberRule implements ValidationRule
{

    protected IncomeType $type;

    public function __construct($type = null)
    {
        $this->type = $type;
    }

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

        $receipt = IncomeReceipt::find($value);

        if (!is_null($receipt) && !$receipt->isActive()) {
            $fail("El número de recibo fue anulado. Debe ser un número de recibo libre o vigente. Sig Num: $validReceiptNumber");
        }

        if (!is_null($this->type) && !IncomeReceipt::verifyUniquePerType($value, $this->type)) {
            $typeLabel = $this->type == IncomeType::NORMAL
                ? "pago"
                : "descuento";

            $fail("El número de recibo ya contiene registrado un $typeLabel. Solo puede haber un registro de tipo $typeLabel por recibo.");
        }
    }
}
