<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'user_id'
    ];

    protected static function getAllowedFilters()
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

    protected static function getAllowedSorts()
    {
        return [
            'nit',
            'name',
            'paternal_surname',
            'maternal_surname',
            'phone',
            'cellphone',
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];
    }

    protected static function getDefaultSort(): String
    {
        return 'name';
    }

    protected static function getAllowedIncludes(): array
    {
        return [];
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
}
