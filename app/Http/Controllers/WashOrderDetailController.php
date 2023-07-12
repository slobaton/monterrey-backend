<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WashOrderDetail;

use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Requests\PaginationRequest;
use App\Http\Resources\WashOrderDetailResource;
use App\Http\Resources\WashOrderDetailCollection;

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
    public function store(Request $request)
    {
        $washOrder = WashOrderDetail::create($request->all());
        $washOrder->clothType;
        $washOrder->clothSize;
        return new WashOrderDetailResource($washOrder);
    }

    /**
     * Display the specified resource.
     */
    public function show(WashOrderDetail $washOrderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WashOrderDetail $washOrderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WashOrderDetail $washOrderDetail)
    {
        //
    }
}
