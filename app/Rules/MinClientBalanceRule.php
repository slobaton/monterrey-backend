<?php

namespace App\Rules;

use Closure;
use App\Models\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class MinClientBalanceRule implements ValidationRule
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $remainingBalance = $this->client->debt_balance;

        if ($value > $remainingBalance) {
            $fail("El monto no debe ser mayor al balance restante. Actual: $remainingBalance");
        }
    }
}
