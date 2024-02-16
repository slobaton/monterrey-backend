<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

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

    public function makePayment($receiptNumber, $amount, $date): bool
    {
        try {
            DB::beginTransaction();

            $clientUpdated = $this->decreaseDebtBalance($amount);
            $movementCreated = AccountMovement::addPayment($this, $receiptNumber, $amount, $date);

            if (!$movementCreated || !$clientUpdated) {
                DB::rollBack();

                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception) {
            DB::rollBack();

            return false;
        }
    }

    public function makeDiscount($concept, $amount, $date): bool
    {
        try {
            DB::beginTransaction();

            $clientUpdated = $this->decreaseDebtBalance($amount);
            $movementCreated = AccountMovement::addDiscount($this, $concept, $amount, $date);

            if (!$movementCreated || !$clientUpdated) {
                DB::rollBack();

                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception) {
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
