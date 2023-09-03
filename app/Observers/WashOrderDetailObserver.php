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
        $washOrder = $washOrderDetail->washOrder;
        $washType = $washOrder->washType;

        // Define wash price
        $clientWashTypePrice = $washType->clientPrices()
            ->where('client_id', $washOrder->client_id)
            ->first();

        $washOrderDetail->wash_price = !is_null($clientWashTypePrice)
            ? $clientWashTypePrice->price
            : $washType->price;

        // Define focalizado price
        if ($washOrderDetail->is_focalizado_active) {
            $focalizadoParam = ChargeParameter::where('name', 'focalizado_price')
                ->firstOrFail();

            $clientFocalizadoPrice = $focalizadoParam->clientPrices()
                ->where('client_id', $washOrder->client_id)
                ->first();

            $washOrderDetail->focalizado_price = !is_null($clientFocalizadoPrice)
                ? $clientFocalizadoPrice->price
                : $focalizadoParam->price;
        }

        // Define nevado price
        if ($washOrderDetail->is_nevado_active) {
            $nevadoParam = ChargeParameter::where('name', 'nevado_price')
                ->firstOrFail();

            $clientNevadoPrice = $nevadoParam->clientPrices()
                ->where('client_id', $washOrder->client_id)
                ->first();

            $washOrderDetail->nevado_price = !is_null($clientNevadoPrice)
                ? $clientNevadoPrice->price
                : $nevadoParam->price;
        }

        $washOrderDetail->unit_price = 0;
        $washOrderDetail->subtotal_price = 0;
    }

    /**
     * Handle the WashOrderDetail "updated" event.
     */
    public function updated(WashOrderDetail $washOrderDetail): void
    {
        //
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
