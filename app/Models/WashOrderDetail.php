<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;

class WashOrderDetail extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'wash_order_id',
        'cloth_type_id',
        'cloth_size_id',
        'wash_price',
        'effect_price',
        'is_focalizado_active',
        'focalizado_price',
        'is_nevado_active',
        'nevado_price',
        'num_buttonholes',
        'buttonholes_price',
        'unit_price',
        'quantity',
        'subtotal_price',
        'observations'
    ];

    protected $casts = [
        'is_focalizado_active' => 'boolean',
        'is_nevado_active' => 'boolean',
        'wash_price' => 'real',
        'effect_price' => 'real',
        'focalizado_price' => 'real',
        'nevado_price' => 'real',
        'buttonholes_price' => 'real',
        'unit_price' => 'real',
        'subtotal_price' => 'real'
    ];

    public function washOrder(): BelongsTo
    {
        return $this->belongsTo(WashOrder::class, 'wash_order_id', 'id');
    }

    public function clothType(): BelongsTo
    {
        return $this->belongsTo(ClothType::class, 'cloth_type_id', 'id');
    }

    public function clothSize(): BelongsTo
    {
        return $this->belongsTo(ClothSize::class, 'cloth_size_id', 'id');
    }

    public function effects(): BelongsToMany
    {
        return $this->belongsToMany(Effect::class, 'wash_order_detail_effect', 'wash_order_detail_id', 'effect_id');
    }

    public function orderEffects(): HasMany
    {
        return $this->hasMany(WashOrderDetailEffect::class, 'wash_order_detail_id', 'id');
    }

    public static function getDefaultSort(): String
    {
        return '-wash_order_id';
    }

    public static function getAllowedIncludes(): array
    {
        return [
            AllowedInclude::relationship('cloth_type', 'clothType'),
            AllowedInclude::relationship('cloth_size', 'clothSize'),
            'effects'
        ];
    }

    public static function getAllowedFilters()
    {
        return [
            AllowedFilter::exact('wash_order_id'),
            AllowedFilter::scope('cloth_type'),
            AllowedFilter::scope('cloth_size'),
            AllowedFilter::scope('observations')
        ];
    }

    protected static function getAllowedSorts()
    {
        return [
            'cloth_type_id',
            'cloth_size_id'
        ];
    }

    public function scopeObservations(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(observations)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function scopeClothType(Builder $query, $search): Builder
    {
        return $query->join('cloth_types', 'wash_orders_details.cloth_type_id', '=', 'cloth_types.id')
            ->where(DB::raw('LOWER(cloth_types.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(cloth_types.description)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function scopeClothSize(Builder $query, $search): Builder
    {
        return $query->join('cloth_sizes', 'wash_orders_details.cloth_type_id', '=', 'cloth_sizes.id')
            ->where(DB::raw('LOWER(cloth_sizes.name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(cloth_sizes.description)'), 'LIKE', "%" . strtolower($search) . "%");
    }
}
