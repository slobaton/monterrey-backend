<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'paternal_surname',
        'maternal_surname',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasAnyRole($roleName)
    {
        return $this->roles()->whereIn('name', $roleName)->exists();
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $password) => bcrypt($password),
        );
    }

    protected static function getAllowedFilters()
    {
        return [
            'username',
            'name',
            'email',
            'paternal_surname',
            'maternal_surname',
            AllowedFilter::scope('all'),
        ];
    }

    protected static function getAllowedSorts()
    {
        return [
            'username',
            'name',
            'email',
            'paternal_surname',
            'maternal_surname',
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
        return $query->where(DB::raw('LOWER(username)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(name)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(paternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(maternal_surname)'), 'LIKE', "%" . strtolower($search) . "%")
            ->orWhere(DB::raw('LOWER(email)'), 'LIKE', "%" . strtolower($search) . "%");
    }

    public function checkBeforeUpdatePassword(Request $request): array
    {
        $userInputs = $request->all();

        if ($request->has('password') && empty($request->password)) {
            unset($userInputs['password']);
        }

        return $userInputs;
    }
}
