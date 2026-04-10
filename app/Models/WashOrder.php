<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Helpers\QueryBuilderHelpers;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedInclude;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class WashOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'client_id',
        'wash_type_id',
        'code',
        'date',
        'total_quantity',
        'total_price',
        'deliver_quantity',
        'deliver_date',
        'observations',
        'is_rewash',
        'rewash_price'
    ];

    protected $casts = [
        'date' => 'date',
        'total_price' => 'real',
        'is_rewash' => 'boolean',
        'rewash_price' => 'real'
    ];

    public function details(): HasMany
    {
        return $this->hasMany(WashOrderDetail::class, 'wash_order_id', 'id');
    }

    public function washType(): BelongsTo
    {
        return $this->belongsTo(WashType::class, 'wash_type_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function printHistories(): HasMany
    {
        return $this->hasMany(PrintHistory::class, 'wash_order_id');
    }

    public function scopeClient(Builder $query, $search): Builder
    {
        if (!QueryBuilderHelpers::isJoined($query, 'clients')) {
            $query->join('clients', 'wash_orders.client_id', '=', 'clients.id')
                ->where(DB::raw('LOWER(clients.name)'), 'LIKE', "%" . strtolower($search) . "%")
                ->orWhere(DB::raw('LOWER(clients.paternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
                ->orWhere(DB::raw('LOWER(clients.maternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
                ->orWhere(DB::raw('LOWER(clients.nit)'), 'LIKE', "%" . strtolower($search) . "%");
        }
        return $query;
    }

    public function scopeWashType(Builder $query, $search): Builder
    {
        if (!QueryBuilderHelpers::isJoined($query, 'wash_types')) {
            $query->join('wash_types', 'wash_orders.wash_type_id', '=', 'wash_types.id')
                ->where(DB::raw('LOWER(wash_types.name)'), 'LIKE', "%" . strtolower($search) . "%")
                ->orWhere(DB::raw('LOWER(wash_types.description)'), 'LIKE', "%" . strtolower($search) . "%");
        }

        return $query;
    }

    public function scopeObservations(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(observations)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function scopeAll(Builder $query, $search): Builder
    {
        if (!QueryBuilderHelpers::isJoined($query, 'clients')) {
            $query->join('clients', 'wash_orders.client_id', '=', 'clients.id');
        }

        if (!QueryBuilderHelpers::isJoined($query, 'wash_types')) {
            $query->join('wash_types', 'wash_orders.wash_type_id', '=', 'wash_types.id');
        }

        $query->where(DB::raw('LOWER(clients.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.paternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.maternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.nit)'), 'LIKE', "%" . strtolower($search) . "%")->where(DB::raw('LOWER(wash_types.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(wash_types.description)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(wash_orders.observations)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhereDate('wash_orders.date', '=', $search)
            ->orWhere(DB::raw('LOWER(wash_orders.code)'), 'LIKE', "%" . $search . "%");

        return $query;
    }

    public function updateTotal()
    {
        $washOrderDetails = $this->details;

        $totalPrice = $washOrderDetails->sum('subtotal_price');
        $totalQuantity = $washOrderDetails->sum("quantity");

        $this->total_price = $totalPrice;
        $this->total_quantity = $totalQuantity;
        $this->save();
    }

    public function getWashPrice()
    {
        if ($this->is_rewash) {
            return $this->rewash_price;
        }

        $washType = $this->washType;

        $clientWashTypePrice = $washType->clientPrices()
            ->where('client_id', $this->client_id)
            ->first();

        return !is_null($clientWashTypePrice)
            ? $clientWashTypePrice->price
            : $washType->price;
    }

    public function getFocalizadoPrice()
    {
        $focalizadoParam = SystemParameter::where('code', SystemParameter::FOCALIZADO_PRICE)
            ->firstOrFail();

        $clientFocalizadoPrice = $focalizadoParam->clientValues()
            ->where('client_id', $this->client_id)
            ->first();

        return !is_null($clientFocalizadoPrice)
            ? $clientFocalizadoPrice->value
            : $focalizadoParam->value;
    }

    public function getNevadoPrice()
    {
        $nevadoParam = SystemParameter::where('code', SystemParameter::NEVADO_PRICE)
            ->firstOrFail();

        $clientNevadoPrice = $nevadoParam->clientValues()
            ->where('client_id', $this->client_id)
            ->first();

        return !is_null($clientNevadoPrice)
            ? $clientNevadoPrice->value
            : $nevadoParam->value;
    }

    public function getMinButtonHolesValue()
    {
        $minButtonHolesParam = SystemParameter::where('code', SystemParameter::BUTTONHOLE_MIN)
            ->firstOrFail();
        $clientMinButtonHolesParam = $minButtonHolesParam->clientValues()
            ->where('client_id', $this->client_id)
            ->first();
        return !is_null($clientMinButtonHolesParam)
            ? $clientMinButtonHolesParam->value
            : $minButtonHolesParam->value;
    }

    public function getPricePerButtonHole()
    {
        $buttonHolePriceParam = SystemParameter::where('code', SystemParameter::BUTTONHOLE_PRICE)
            ->firstOrFail();
        $clientButtonHolePriceParam = $buttonHolePriceParam->clientValues()
            ->where('client_id', $this->client_id)
            ->first();
        return !is_null($clientButtonHolePriceParam)
            ? $clientButtonHolePriceParam->value
            : $buttonHolePriceParam->value;
    }

    public function getButtonHolesPrice($minButtonHoles, $pricePerButtonHole, $numButtonHoles)
    {
        $validButtonHoles = $numButtonHoles - $minButtonHoles;

        return $validButtonHoles > 0 ? $validButtonHoles * $pricePerButtonHole : 0;
    }

    public function approveOrder(): bool
    {
        try {
            DB::beginTransaction();

            $amount = $this->total_price;
            $client = $this->client;

            $this->status = OrderStatus::APPROVED->value;
            $orderUpdated = $this->save();
            $clientUpdated = $client->increaseDebtBalance($amount);
            $movementCreated = AccountMovement::addCharge($this, $this->total_price);

            if (!$orderUpdated || !$movementCreated || !$clientUpdated) {
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

    public static function getDefaultSort(): String
    {
        return '-code';
    }

    public static function getAllowedIncludes(): array
    {
        return [
            'client',
            'details',
            AllowedInclude::relationship('wash_type', 'washType')
        ];
    }

    public static function getAllowedFilters()
    {
        return [
            AllowedFilter::scope('client'),
            AllowedFilter::scope('wash_type'),
            AllowedFilter::scope('all'),
            AllowedFilter::scope('observations'),
            AllowedFilter::exact('date', 'date'),
            AllowedFilter::exact('code', 'code'),
            'total_price',
        ];
    }

    protected static function getAllowedSorts()
    {
        return [
            'code',
            'date',
            'total_price',
            'total_quantity',
            'is_rewash'
        ];
    }

    public static function getOrdersCount()
    {
        return WashOrder::count();
    }

    public static function getOrdersTotalRevenue(): float
    {
        $totalRevenue = WashOrder::sum('total_price');

        return (float)$totalRevenue;
    }

    // report
    public function checkPermissionOrFail(): void
    {
        if ($this->status === OrderStatus::CREATED->value) {
            abort_json(403, 'No tienes permiso.');
        }
    }

    public function checkIfUserCanPrint($washOrder, $user): void
    {
        if ($washOrder->printHistories()->count() > 1 && ! $user->isAdmin()) {
            abort_json(403, 'No está permitido imprimir más de una vez a menos que seas administrador.');
        }
    }

    public function recordPrintHistory($userId): void
    {
        PrintHistory::create([
            'user_id' => $userId,
            'wash_order_id' => $this->id,
            'created_at' => Carbon::now(),
        ]);
    }

    public function prepareReportData($user): array
    {
        return [
            'user' => $user,
            'client' => $this->client,
            'washOrder' => $this,
            'details' => $this->details
        ];
    }
}
