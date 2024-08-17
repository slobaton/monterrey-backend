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
        'price' => 'real',
        'is_active' => 'boolean',
    ];

    public function clientPrices(): HasMany
    {
        return $this->hasMany(ClientEffectPrice::class, 'effect_id', 'id');
    }

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(description)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(is_active)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public static function getEffectsWithClientPrices($clientId)
    {
        return Effect::leftJoin('client_effect_prices as cefp', function ($join) use ($clientId) {
            $join->on('effects.id', '=', 'cefp.effect_id')
                ->where('cefp.client_id', '=', $clientId);
        })
            ->select([
                'effects.id',
                'effects.name',
                'effects.description',
                'effects.is_active',
                'effects.created_at',
                'effects.updated_at',
                DB::raw('CASE WHEN cefp.price IS NOT NULL THEN cefp.price ELSE effects.price END as price')
            ])
            ->orderBy('effects.name')
            ->get();
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

    public static function getActiveCount(): int
    {
        return Effect::where('is_active', true)
            ->count();
    }

    public static function getInactiveCount(): int
    {
        return Effect::where('is_active', false)
            ->count();
    }
}
