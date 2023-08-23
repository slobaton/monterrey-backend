<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientParameterPrice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'charge_parameter_id',
        'client_id',
        'price'
    ];

    protected $casts = [
        'price' => 'real',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function chargeParameter(): BelongsTo
    {
        return $this->belongsTo(ChargeParameter::class);
    }
}
