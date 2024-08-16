<?php

namespace App\Models;

use App\Enums\IncomeReceiptStatus;
use App\Enums\IncomeType;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

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

    public function scopeAll(Builder $query, $search): Builder
    {
        return $query->where('id', '=', $search);
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
            DB::beginTransaction();

            $canceledReceipt = new IncomeReceipt();
            $canceledReceipt->id = $receiptNumber;
            $canceledReceipt->user_id = $userId;
            $canceledReceipt->date = $date;
            $canceledReceipt->canceled_reason = $canceledReason;
            $canceledReceipt->status = IncomeReceiptStatus::CANCELED->value;

            $receiptCanceled = $canceledReceipt->save();
            $incomeCreated = Income::addIncome($canceledReceipt->id, "Recibo Cancelado - {$canceledReason}", IncomeType::EMPTY->value, 0, $date);

            if (!$receiptCanceled || !$incomeCreated) {
                DB::rollBack();

                return false;
            }

            DB::commit();

            return true;
        } catch (\Exception $ex) {
            Log::error("Unexpected error happened trying to cancel the income receipt :: Exception: {ex}", ["ex" => $ex]);
            DB::rollBack();

            return false;
        }
    }

    public static function getAllowedFilters()
    {
        return [
            'id',
            'date',
            AllowedFilter::scope('all'),
        ];
    }

    public static function getAllowedSorts()
    {
        return [
            'id',
            'date',
            AllowedSort::field('created_at'),
            AllowedSort::field('updated_at'),
        ];
    }

    public static function getDefaultSort(): String
    {
        return '-id';
    }

    public static function getAllowedIncludes(): array
    {
        return [];
    }
}
