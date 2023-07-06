<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;

final class WashOrder extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'client_id',
        'wash_type_id',
        'date',
        'total_quantity',
        'total_price',
        'deliver_quantity',
        'deliver_date',
        'observations',
        'code'
    ];

    public function washType(): BelongsTo
    {
        return $this->belongsTo(WashType::class, 'wash_type_id', 'id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public static function getDefaultSort(): String
    {
        return '-date';
    }

    public static function getAllowedIncludes(): array
    {
        return ['client', 'washType'];
    }

    public static function getAllowedFilters()
    {
        return [
            AllowedFilter::scope('client'),
            AllowedFilter::exact('date', 'date'),
        ];
    }

    protected static function getAllowedSorts()
    {
        return [];
    }

    public function scopeClient(Builder $query, $search): Builder
    {
        return $query->join('clients', 'wash_orders.client_id', '=', 'clients.id')
            ->where(DB::raw('LOWER(clients.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.paternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.maternal_surname)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function scopeWashType(Builder $query, $search): Builder
    {
        return $query->join('clients', 'wash_orders.client_id', '=', 'clients.id')
            ->where(DB::raw('LOWER(clients.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.paternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(clients.maternal_surname)'), 'LIKE', "%" . strtolower($search) . "%");
    }
}
