<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WashType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'is_active'
    ];

    protected $casts = [
        'price'     => 'real',
        'is_active' => 'boolean',
    ];

    public function clientPrices(): HasMany
    {
        return $this->hasMany(ClientWashTypePrice::class, 'wash_type_id', 'id');
    }

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where(DB::raw('LOWER(name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(price)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(description)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public static function getAllowedFilters()
    {
        return [
            'name',
            'price',
            'description',
            AllowedFilter::scope('all'),
        ];
    }

    public static function getAllowedSorts()
    {
        return [
            'name',
            'price',
            'description',
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
}
