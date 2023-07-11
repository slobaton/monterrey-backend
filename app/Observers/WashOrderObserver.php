<?php

namespace App\Observers;

use App\Models\WashOrder;

class WashOrderObserver
{
    /**
     * Handle the WashOrder "created" event.
     */
    public function creating(WashOrder $washOrder): void
    {
        $lastWashOrderUuid = $washOrder->query()->latest()->first();

        $washOrder->code = $lastWashOrderUuid ? $lastWashOrderUuid->code + 1 : 1;
    }

    /**
     * Handle the WashOrder "updated" event.
     */
    public function updated(WashOrder $washOrder): void
    {
        //
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
