<?php

namespace App\Observers;

use App\Models\ChargeParameter;
use App\Models\WashOrderDetail;

class WashOrderDetailObserver
{
    /**
     * Handle the WashOrderDetail "creating" event.
     */
    public function creating(WashOrderDetail $washOrderDetail): void
    {
        $washOrderDetail->updateParams();

        $washOrderDetail->unit_price = 0;
        $washOrderDetail->subtotal_price = 0;
    }

    /**
     * Handle the WashOrderDetail "updated" event.
     */
    public function updating(WashOrderDetail $washOrderDetail): void
    {
        $washOrderDetail->updateParams();
    }

    /**
     * Handle the WashOrderDetail "deleted" event.
     */
    public function deleted(WashOrderDetail $washOrderDetail): void
    {
        //
    }

    /**
     * Handle the WashOrderDetail "restored" event.
     */
    public function restored(WashOrderDetail $washOrderDetail): void
    {
        //
    }

    /**
     * Handle the WashOrderDetail "force deleted" event.
     */
    public function forceDeleted(WashOrderDetail $washOrderDetail): void
    {
        //
    }
}
