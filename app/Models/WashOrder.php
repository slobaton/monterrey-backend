<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\AllowedInclude;
use Illuminate\Database\Eloquent\Builder;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

final class WashOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

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
        return [
            'client',
            AllowedInclude::relationship('wash_type', 'washType')
        ];
    }

    public static function getAllowedFilters()
    {
        return [
            AllowedFilter::scope('client'),
            AllowedFilter::scope('wash_type'),
            AllowedFilter::scope('observations'),
            AllowedFilter::exact('date', 'date'),
            AllowedFilter::exact('code', 'code'),
            'total_price'
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
        return $query->join('wash_types', 'wash_orders.wash_type_id', '=', 'wash_types.id')
            ->where(DB::raw('LOWER(wash_types.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(wash_types.description)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function scopeObservations(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(observations)'), 'LIKE', "%" . strtolower($search) . "%");
    }
}
