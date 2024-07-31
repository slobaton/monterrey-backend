<?php

namespace App\Models;

use App\Enums\IncomeReceiptStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IncomeReceipt extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'date',
        'concept',
        'status',
        'canceled_reason'
    ];

    public $incrementing = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function isActive(): bool
    {
        return $this->status == IncomeReceiptStatus::ACTIVE->value;
    }

    public static function getNextConsecutive(): int
    {
        $receipt = IncomeReceipt::orderBy('id', 'desc')
            ->first();

        return is_null($receipt) ? 1 : ($receipt->id + 1);
    }

    public static function verifyNumber($receiptNumber): bool
    {
        $receipt = IncomeReceipt::find($receiptNumber);

        if (!is_null($receipt) || $receiptNumber == 1) {
            return true;
        }

        $previousReceipt = IncomeReceipt::find($receiptNumber - 1);

        return !is_null($previousReceipt);
    }
}
