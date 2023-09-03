<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Effect extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'description',
        'price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function clientPrices(): HasMany
    {
        return $this->hasMany(ClientEffectPrice::class, 'effect_id', 'id');
    }

    public static function getAllowedFilters(): array
    {
        return [
            'name',
            'description',
            'is_active',
            AllowedFilter::scope('all'),
        ];
    }

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(description)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(is_active)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public static function getAllowedSorts(): array
    {
        return [
            'name',
            'description',
            'is_active',
            'price',
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];
    }

    public static function getDefaultSort(): String
    {
        return 'name';
    }

    protected static function getAllowedIncludes(): array
    {
        return [];
    }
}
