<?php

namespace App\Models;

use App\Enums\AccountMovementType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountMovement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'wash_order_id',
        'date',
        'type',
        'amount'
    ];

    protected $casts = [
        'amount' => 'real',
    ];

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(date)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(amount)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public static function getAllowedFilters()
    {
        return [
            'date',
            'type',
            'amount',
            AllowedFilter::scope('all'),
        ];
    }

    public static function getAllowedSorts()
    {
        return [
            'date',
            'type',
            'amount',
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];
    }

    public static function getDefaultSort(): String
    {
        return 'date';
    }

    public static function getAllowedIncludes(): array
    {
        return [];
    }

    public static function addCharge(WashOrder $washOrder, $amount): bool
    {
        $accountMovement = new AccountMovement();
        $accountMovement->client_id = $washOrder->client_id;
        $accountMovement->wash_order_id = $washOrder->id;
        $accountMovement->date = Date::now();
        $accountMovement->type = AccountMovementType::CHARGE->value;
        $accountMovement->amount = $amount;

        return $accountMovement->save();
    }

    public static function addPayment(WashOrder $washOrder, $amount): bool
    {
        $accountMovement = new AccountMovement();
        $accountMovement->client_id = $washOrder->client_id;
        $accountMovement->wash_order_id = $washOrder->id;
        $accountMovement->date = Date::now();
        $accountMovement->type = AccountMovementType::PAYMENT->value;
        $accountMovement->amount = -$amount;

        return $accountMovement->save();
    }
}
