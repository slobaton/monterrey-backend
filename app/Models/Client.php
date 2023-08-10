<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function washTypes(): BelongsToMany
    {
        return $this->belongsToMany(WashType::class, 'client_wash_type_prices')
            ->orderByPivot('created_at', 'desc')
            ->withPivot(['id', 'price'])
            ->as('washTypePrices');
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
}
