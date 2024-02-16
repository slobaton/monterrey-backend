<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Effect;
use App\Models\WashOrder;

use App\Enums\OrderStatus;

use App\Models\WashOrderDetail;
use App\Models\WashOrderDetailEffect;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\WashOrderDetailResource;
use App\Http\Resources\WashOrderDetailCollection;
use App\Http\Requests\StoreWashOrderDetailRequest;
use App\Http\Requests\UpdateWashOrderDetailRequest;
use App\Http\Requests\CalculateWashOrderDetailPriceRequest;

class WashOrderDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value . ',' . Roles::RECEPTIONIST->value);
    }

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
     * Display the specified resource.
     */
    public function show(WashOrderDetail $washOrderDetail)
    {
        $query = WashOrderDetail::where('id', $washOrderDetail->id);

        $washOrderDetail = QueryBuilder::for($query)
            ->allowedIncludes(WashOrderDetail::getAllowedIncludes())
            ->firstOrFail();

        return new WashOrderDetailResource($washOrderDetail);
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
        $washOrderDetail->effects;

        $washOrderDetail->updateSubtotal();
        $washOrder->updateTotal();

        return new WashOrderDetailResource($washOrderDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWashOrderDetailRequest $request, WashOrderDetail $washOrderDetail)
    {
        $washOrderDetail->update($request->all());
        $washOrder = $washOrderDetail->washOrder;

        if ($request->has('effects')) {
            $washOrderDetail->effects()->sync($request->effects);

            foreach ($request->effects as $effectId) {
                $effect = Effect::where('id', $effectId)
                    ->firstOrFail();

                $clientEffectPrice = $effect->clientPrices()
                    ->where('client_id', $washOrder->client_id)
                    ->first();

                $washOrderDetailEffect = WashOrderDetailEffect::where('wash_order_detail_id', $washOrderDetail->id)
                    ->where('effect_id', $effectId)
                    ->first();

                if (!is_null($washOrderDetailEffect)) {
                    $washOrderDetailEffect->price = !is_null($clientEffectPrice)
                        ? $clientEffectPrice->price
                        : $effect->price;

                    $washOrderDetailEffect->saveOrFail();
                }
            }
        }

        $washOrderDetail->clothType;
        $washOrderDetail->clothSize;
        $washOrderDetail->effects;

        $washOrderDetail->updateSubtotal();
        $washOrder->updateTotal();

        return new WashOrderDetailResource($washOrderDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WashOrderDetail $washOrderDetail)
    {
        $washOrder = $washOrderDetail->washOrder;

        if ($washOrder->status !== OrderStatus::CREATED->value) {
            return $this->respondForbidden();
        }

        $washOrderDetail->effects()->detach();
        $washOrderDetail->delete();

        $washOrder->updateTotal();

        return $this->respondWithSuccess([
            'message' => 'Wash Order Detail has been deleted'
        ]);
    }

    public function calculatePrices(CalculateWashOrderDetailPriceRequest $request)
    {
        $washOrder = WashOrder::where('id', $request->wash_order_id)
            ->firstOrFail();
        $client = $washOrder->client;

        $washPrice = $washOrder->getWashPrice();
        $isFocalizadoActive = $request->has('is_focalizado_active') && !is_null($request->is_focalizado_active)
            ? $request->is_focalizado_active
            : false;
        $isNevadoActive = $request->has('is_nevado_active') && !is_null($request->is_nevado_active)
            ? $request->is_nevado_active
            : false;
        $focalizadoPrice = $washOrder->getFocalizadoPrice();
        $nevadoPrice = $washOrder->getNevadoPrice();
        $numButtonHoles = $request->has('num_buttonholes') && !is_null($request->num_buttonholes)
            ? $request->num_buttonholes
            : 0;
        $minButtonHoles = $client->getMinButtonHolesValue();
        $pricePerButtonHole = $client->getPricePerButtonHole();
        $buttonHolesPrice = $client->getButtonHolesPrice($minButtonHoles, $pricePerButtonHole, $numButtonHoles);
        $effectTotalPrice = 0;

        $quantity = $request->has('quantity') && !is_null($request->quantity)
            ? $request->quantity
            : 0;

        if ($request->has('effects') && !is_null($request->effects)) {
            foreach ($request->effects as $effectId) {
                $effect = Effect::where('id', $effectId)
                    ->firstOrFail();

                $clientEffectPrice = $effect->clientPrices()
                    ->where('client_id', $washOrder->client_id)
                    ->first();

                $effectTotalPrice += !is_null($clientEffectPrice)
                    ? $clientEffectPrice->price
                    : $effect->price;
            }
        }

        $unitPrice = $washPrice + $buttonHolesPrice + $effectTotalPrice;

        if ($isFocalizadoActive) {
            $unitPrice += $focalizadoPrice;
        }

        if ($isNevadoActive) {
            $unitPrice += $nevadoPrice;
        }

        $subtotalPrice = $unitPrice * $quantity;

        return $this->respondWithSuccess([
            'wash_price' => $washPrice,
            'focalizado_price' => $isFocalizadoActive ? $focalizadoPrice : 0,
            'nevado_price' => $isNevadoActive ? $nevadoPrice : 0,
            'price_per_buttonhole' => $pricePerButtonHole,
            'min_buttonholes' => $minButtonHoles,
            'buttonholes_total_price' => $buttonHolesPrice,
            'effect_total_price' => $effectTotalPrice,
            'unit_price' => $unitPrice,
            'subtotal_price' => $subtotalPrice
        ]);
    }
}
