<?php

namespace App\Http\Controllers;

use App\Models\WashOrder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\PaginationRequest;
use App\Http\Resources\WashOrderResource;
use App\Http\Resources\WashOrderCollection;
use App\Http\Requests\StoreWashOrderRequest;

class WashOrderController extends Controller
{
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
        $washOrder = QueryBuilder::for($order)
            ->allowedIncludes(WashOrder::getAllowedIncludes())
            ->firstOrFail();

        return new WashOrderResource($washOrder);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
