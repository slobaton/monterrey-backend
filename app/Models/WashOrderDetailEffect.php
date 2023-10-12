<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WashOrderDetailEffect extends Model
{
    use HasFactory;

    protected $table = 'wash_order_detail_effect';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wash_order_detail_id',
        'effect_id',
        'price'
    ];

    protected $casts = [
        'price' => 'real',
    ];

    public function effect(): BelongsTo
    {
        return $this->belongsTo(Effect::class, 'effect_id', 'id');
    }
}
