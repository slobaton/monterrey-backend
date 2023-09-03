<?php

namespace App\Http\Controllers;

use App\Models\WashOrderDetail;

use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\PaginationRequest;
use App\Http\Resources\WashOrderDetailResource;
use App\Http\Resources\WashOrderDetailCollection;
use App\Http\Requests\StoreWashOrderDetailRequest;
use App\Http\Requests\UpdateWashOrderDetailRequest;
use App\Models\Effect;
use App\Models\WashOrderDetailEffect;

class WashOrderDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        $washOrderDetail = QueryBuilder::for(WashOrderDetail::class)
            ->allowedFilters(WashOrderDetail::getAllowedFilters())
            ->defaultSort(WashOrderDetail::getDefaultSort())
            ->allowedSorts(WashOrderDetail::getAllowedSorts())
            ->allowedIncludes(WashOrderDetail::getAllowedIncludes());

        $washOrderDetail = $request->has('page.number') && $request->has('page.size')
            ? $washOrderDetail->jsonPaginate()
            : $washOrderDetail->get();

        return new WashOrderDetailCollection($washOrderDetail);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWashOrderDetailRequest $request)
    {
        $washOrderDetail = WashOrderDetail::create($request->all());
        $washOrder = $washOrderDetail->washOrder;

        if ($request->has('effects')) {
            foreach ($request->effects as $effectId) {
                $effect = Effect::where('id', $effectId)
                    ->firstOrFail();

                $clientEffectPrice = $effect->clientPrices()
                    ->where('client_id', $washOrder->client_id)
                    ->first();

                WashOrderDetailEffect::create([
                    'wash_order_detail_id' => $washOrderDetail->id,
                    'effect_id' => $effect->id,
                    'price' => !is_null($clientEffectPrice)
                        ? $clientEffectPrice->price
                        : $effect->price
                ]);
            }
        }

        $washOrderDetail->clothSize;
        $washOrderDetail->clothType;
        $WashOrderDetailEffects = $washOrderDetail->orderEffects;
        $washOrderDetail->effects;

        $washPrice = $washOrderDetail->wash_price;

        $totalEffectsPrice = !$WashOrderDetailEffects->isEmpty()
            ? $WashOrderDetailEffects->sum('price')
            : 0;
        $washOrderDetail->effect_price = $totalEffectsPrice;


        $focalizadoPrice = $washOrderDetail->is_focalizado_active
            ? $washOrderDetail->focalizado_price
            : 0;

        $nevadoPrice = $washOrderDetail->is_nevado_active
            ? $washOrderDetail->nevado_price
            : 0;

        $buttonholes_price = $washOrderDetail->buttonholes_price * $washOrderDetail->num_buttonholes;

        $washOrderDetail->unit_price = $washPrice + $totalEffectsPrice + $focalizadoPrice + $nevadoPrice + $buttonholes_price;
        $washOrderDetail->subtotal_price = $washOrderDetail->unit_price * $washOrderDetail->quantity;

        $washOrderDetail->save();

        $washOrderDetails = $washOrder->details;

        $totalPrice = $washOrderDetails->sum('subtotal_price');
        $totalQuantity = $washOrderDetails->sum("quantity");

        $washOrder->total_price = $totalPrice;
        $washOrder->total_quantity = $totalQuantity;
        $washOrder->save();

        return new WashOrderDetailResource($washOrderDetail);
    }

    /**
     * Display the specified resource.
     */
    public function show(WashOrderDetail $washOrderDetail)
    {
        $washOrder = QueryBuilder::for($washOrderDetail)
            ->allowedIncludes(WashOrderDetail::getAllowedIncludes())
            ->firstOrFail();

        return new WashOrderDetailResource($washOrder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWashOrderDetailRequest $request, WashOrderDetail $washOrderDetail)
    {
        $washOrderDetail->update($request->all());

        if ($request->has('effects')) {
            $washOrderDetail->effects()->sync($request->effects);
        }

        $washOrderDetail->clothType;
        $washOrderDetail->clothSize;
        $washOrderDetail->effects;

        return new WashOrderDetailResource($washOrderDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WashOrderDetail $washOrderDetail)
    {
        $washOrderDetail->effects()->detach();
        $washOrderDetail->delete();

        return $this->respondWithSuccess([
            'message' => 'Wash Order Detail has been deleted'
        ]);
    }
}
