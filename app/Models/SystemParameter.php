<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SystemParameter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'value'
    ];

    protected $casts = [
        'value' => 'real',
    ];

    const FOCALIZADO_PRICE = 'focalizado_price';
    const NEVADO_PRICE = 'nevado_price';
    const BUTTONHOLE_PRICE = 'buttonhole_price';
    const BUTTONHOLE_MIN = 'buttonhole_min';
    const CURRENCY_CHANGE_RATE = 'currency_change_rate';

    public function clientValues(): HasMany
    {
        return $this->hasMany(ClientParameterValue::class, 'system_parameter_id', 'id');
    }
}
