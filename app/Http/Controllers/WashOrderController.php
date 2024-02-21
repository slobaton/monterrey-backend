<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\WashOrder;

use App\Enums\OrderStatus;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\WashOrderResource;
use App\Http\Resources\WashOrderCollection;
use App\Http\Requests\StoreWashOrderRequest;
use App\Http\Requests\UpdateWashOrderRequest;

class WashOrderController extends Controller
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
        $washOrder = QueryBuilder::for(WashOrder::class)
            ->allowedFilters(WashOrder::getAllowedFilters())
            ->defaultSort(WashOrder::getDefaultSort())
            ->allowedSorts(WashOrder::getAllowedSorts())
            ->allowedIncludes(WashOrder::getAllowedIncludes());

        $washOrder = $request->has('page.number') && $request->has('page.size')
            ? $washOrder->jsonPaginate()
            : $washOrder->get();

        return new WashOrderCollection($washOrder);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWashOrderRequest $request): WashOrderResource
    {
        $washOrder = WashOrder::create($request->all());

        $washOrder->client;
        $washOrder->washType;

        return new WashOrderResource($washOrder);
    }

    /**
     * Display the specified resource.
     */
    public function show(WashOrder $order)
    {
        $query = WashOrder::where('id', $order->id);

        $washOrder = QueryBuilder::for($query)
            ->allowedIncludes(WashOrder::getAllowedIncludes())
            ->firstOrFail();

        return new WashOrderResource($washOrder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWashOrderRequest $request, WashOrder $order)
    {
        $order->update($request->all());

        foreach ($order->details as $detail) {
            $detail->updateParams();
            $detail->updateSubtotal();
        }

        $order->updateTotal();

        return new WashOrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WashOrder $order)
    {
        if ($order->status !== OrderStatus::CREATED->value) {
            return $this->respondForbidden();
        }

        $order->delete();

        return $this->respondWithSuccess([
            'message' => 'Wash Order has been deleted'
        ]);
    }

    /**
     * Approve the specified order
     */
    public function approveOrder(WashOrder $washOrder)
    {
        if ($washOrder->status !== OrderStatus::CREATED->value) {
            return $this->respondError('Wash Order cannot be approved');
        }

        if (count($washOrder->details) == 0) {
            return $this->respondError('Wash Order cannot be approved');
        }

        $orderApproved = $washOrder->approveOrder();

        if (!$orderApproved) {
            return $this->respondError('Cannot approve the order');
        }

        return new WashOrderResource($washOrder);
    }

    public function fetchOrdersByClient(PaginationRequest $request, string $client)
    {
        $washOrder = QueryBuilder::for(WashOrder::where('client_id', $client))
            ->allowedFilters(WashOrder::getAllowedFilters())
            ->defaultSort(WashOrder::getDefaultSort())
            ->allowedSorts(WashOrder::getAllowedSorts())
            ->allowedIncludes(WashOrder::getAllowedIncludes());

        $washOrder = $request->has('page.number') && $request->has('page.size')
            ? $washOrder->jsonPaginate()
            : $washOrder->get();

        return new WashOrderCollection($washOrder);
    }
}
