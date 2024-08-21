<?php

namespace App\Rules;

use App\Models\AccountMovement;
use Closure;
use App\Models\Client;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Date;

class MinClientBalanceRule implements ValidationRule
{
    protected Client $client;
    protected $date;

    public function __construct(Client $client, string $date = null)
    {
        $this->client = $client;
        $this->date = !is_null($date) ? Date::parse($date) : Date::now();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $balanceUntilDate = AccountMovement::getBalanceUntilDate($this->client->id, $this->date, considerDate: true);

        if ($value > $balanceUntilDate) {
            $fail("El monto no debe ser mayor al balance restante hasta la fecha: $balanceUntilDate");
        }
    }
}
