<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $password) => bcrypt($password),
        );
    }

    protected static function getAllowedFilters()
    {
        return [
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
            'name',
            'email',
            'paternal_surname',
            'maternal_surname',
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];
    }

    protected static function getDefaultSort()
    {
        return 'name';
    }

    protected static function getAllowedIncludes()
    {
        return [];
    }

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where('name', 'ILIKE', "%{$search}%")
            ->orWhere('paternal_surname', '=', $search)
            ->orWhere('maternal_surname', '=', $search)
            ->orWhere('email', '=', $search);
    }

    public function checkBeforeUpdatePassword(Request $request): Array
    {
      $userInputs = $request->all();

      if ($request->has('password') && empty($request->password)) {
          unset($userInputs['password']);
      }

      return $userInputs;
    }
}
