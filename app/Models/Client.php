<?php

namespace App\Models;

use App\Enums\IncomeType;
use App\Enums\IncomeReceiptStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nit',
        'name',
        'paternal_surname',
        'maternal_surname',
        'phone',
        'cellphone',
        'address',
        'observations',
        'is_active',
        'debt_balance'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'debt_balance' => 'real'
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn(string $value, array $attributes) => "{$attributes['name']} {$attributes['paternal_surname']} {$attributes['maternal_surname']}"
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function washTypes(): BelongsToMany
    {
        return $this->belongsToMany(WashType::class, 'client_wash_type_prices')
            ->orderByPivot('created_at', 'desc')
            ->withPivot(['id', 'price']);
    }

    public function effects(): BelongsToMany
    {
        return $this->belongsToMany(Effect::class, 'client_effect_prices')
            ->orderByPivot('created_at', 'desc')
            ->withPivot(['id', 'price']);
    }

    public function parameters(): BelongsToMany
    {
        return $this->belongsToMany(SystemParameter::class, 'client_parameter_values')
            ->orderByPivot('created_at', 'desc')
            ->withPivot(['id', 'value']);
    }

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(nit)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(paternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(maternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(phone)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(cellphone)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function getFullnameAttribute()
    {
        return $this->attributes['name'] . ' ' . $this->attributes['paternal_surname'] . ' ' . $this->attributes['maternal_surname'];
    }

    public function makePayment($receiptNumber, $amount, $date, $userId): bool
    {
        try {
            DB::beginTransaction();

            $clientUpdated = $this->decreaseDebtBalance($amount);
            $receipt = IncomeReceipt::firstOrCreate(
                ['id' => $receiptNumber],
                ['id' => $receiptNumber, 'date' => $date, 'status' => IncomeReceiptStatus::ACTIVE->value, 'user_id' => $userId]
            );
            $incomeCreated = Income::addIncome($receipt->id, $this->full_name, IncomeType::NORMAL->value, $amount, $date);
            $movementCreated = AccountMovement::addPayment($this, $receipt->id, $amount, $date);

            if (!$movementCreated || !$clientUpdated || !$incomeCreated) {
                DB::rollBack();

                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception $ex) {
            Log::error("Unexpected error happened making the payment :: Exception: {ex}", ['ex' => $ex]);
            DB::rollBack();

            return false;
        }
    }

    public function makeDiscount($receiptNumber, $concept, $amount, $date, $userId): bool
    {
        try {
            DB::beginTransaction();

            $clientUpdated = $this->decreaseDebtBalance($amount);
            $receipt = IncomeReceipt::firstOrCreate(
                ['id' => $receiptNumber],
                ['id' => $receiptNumber, 'date' => $date, 'status' => IncomeReceiptStatus::ACTIVE->value, 'user_id' => $userId]
            );
            $incomeCreated = Income::addIncome($receipt->id, $this->full_name, IncomeType::WITHLOSS->value, $amount, $date);
            $movementCreated = AccountMovement::addDiscount($this, $receiptNumber, $concept, $amount, $date);

            if (!$movementCreated || !$clientUpdated || !$incomeCreated) {
                DB::rollBack();

                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception $ex) {
            Log::error("Unexpected error happened making the discount :: Exception: {ex}", ['ex' => $ex]);
            DB::rollBack();

            return false;
        }
    }

    public function increaseDebtBalance($amount): bool
    {
        $this->debt_balance += $amount;

        return $this->save();
    }

    public function decreaseDebtBalance($amount): bool
    {
        $this->debt_balance -= $amount;

        return $this->save();
    }

    public function getCurrencyRate()
    {
        $currencyRateParam = SystemParameter::where('code', SystemParameter::CURRENCY_CHANGE_RATE)
            ->firstOrFail();

        $clientCurrencyRateParam = $currencyRateParam->clientValues()
            ->where('client_id', $this->id)
            ->first();

        return $clientCurrencyRateParam
            ? $clientCurrencyRateParam->value
            : $currencyRateParam->value;
    }

    public static function getAllowedFilters()
    {
        return [
            'nit',
            'name',
            'paternal_surname',
            'maternal_surname',
            'phone',
            'cellphone',
            'address',
            AllowedFilter::scope('all'),
        ];
    }

    public static function getAllowedSorts()
    {
        return [
            'nit',
            'name',
            'paternal_surname',
            'maternal_surname',
            'phone',
            'cellphone',
            'is_active',
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];
    }

    public static function getDefaultSort(): String
    {
        return 'name';
    }

    public static function getAllowedIncludes(): array
    {
        return [];
    }

    public static function getActiveClientsCount(): int
    {
        return Client::where('is_active', true)
            ->count();
    }

    public static function getInactiveClientsCount(): int
    {
        return Client::where('is_active', false)
            ->count();
    }
}
