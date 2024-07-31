<?php

namespace App\Models;

use App\Enums\IncomeReceiptStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

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
        'canceled_reason',
        'status'
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

    public static function verifyCancelableNumber($receiptNumber): bool
    {
        $receipt = IncomeReceipt::find($receiptNumber);

        if (!is_null($receipt)) {
            return false;
        }

        if ($receiptNumber == 1) {
            return true;
        }

        $previousReceiptNumber = $receiptNumber - 1;
        $previousReceipt = IncomeReceipt::find($previousReceiptNumber);

        return !is_null($previousReceipt);
    }

    public static function cancelReceipt($receiptNumber, $canceledReason, $date, $userId): bool
    {
        try {
            $canceledReceipt = new IncomeReceipt();
            $canceledReceipt->id = $receiptNumber;
            $canceledReceipt->user_id = $userId;
            $canceledReceipt->date = $date;
            $canceledReceipt->canceled_reason = $canceledReason;
            $canceledReceipt->status = IncomeReceiptStatus::CANCELED->value;

            return $canceledReceipt->save();
        } catch (\Exception $ex) {
            Log::error("Unexpected error happened trying to cancel the income receipt :: Exception: {ex}", ["ex" => $ex]);

            return false;
        }
    }
}
