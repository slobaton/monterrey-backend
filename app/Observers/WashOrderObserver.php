<?php

namespace App\Observers;

use App\Enums\OrderStatus;
use App\Models\WashOrder;

class WashOrderObserver
{
    /**
     * Handle the WashOrder "creating" event.
     */
    public function creating(WashOrder $washOrder): void
    {
        $lastWashOrderUuid = $washOrder->query()
            ->withTrashed()
            ->latest()
            ->first();

        $washOrder->code = $lastWashOrderUuid ? $lastWashOrderUuid->code + 1 : 1;
        $washOrder->total_quantity = 0;
        $washOrder->total_price = 0;
        $washOrder->status = OrderStatus::CREATED->value;
    }

    /**
     * Handle the WashOrder "updated" event.
     */
    public function updated(WashOrder $washOrder): void
    {
    }

    /**
     * Handle the WashOrder "deleted" event.
     */
    public function deleted(WashOrder $washOrder): void
    {
        //
    }

    /**
     * Handle the WashOrder "restored" event.
     */
    public function restored(WashOrder $washOrder): void
    {
        //
    }

    /**
     * Handle the WashOrder "force deleted" event.
     */
    public function forceDeleted(WashOrder $washOrder): void
    {
        //
    }
}
