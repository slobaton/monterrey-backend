<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Income extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'receipt_number',
        'date',
        'concept',
        'type',
        'amount'
    ];

    protected $casts = [
        'amount' => 'real',
    ];

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(IncomeReceipt::class, 'receipt_number', 'id');
    }
}
