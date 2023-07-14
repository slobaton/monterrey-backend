<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WashOrderDetail;

use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\PaginationRequest;
use App\Http\Resources\WashOrderDetailResource;
use App\Http\Resources\WashOrderDetailCollection;
use App\Http\Requests\StoreWashOrderDetailRequest;
use App\Http\Requests\UpdateWashOrderDetailRequest;

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
        if ($request->has('effects')) {
            $washOrderDetail->effects()->attach($request->effects);
        }
        $washOrderDetail->clothType;
        $washOrderDetail->clothSize;
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
        return new WashOrderDetailResource($washOrderDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WashOrderDetail $washOrderDetail)
    {
        $washOrderDetail->delete();

        return $this->respondWithSuccess([
            'message' => 'Wash Order Detail has been deleted'
        ]);
    }
}
