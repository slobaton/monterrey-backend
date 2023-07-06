<?php

namespace App\Http\Controllers;

use App\Models\WashOrder;
use App\Http\Requests\PaginationRequest;

use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

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

        return ($washOrder);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        WashOrder::create($request->all());

        return $this->respondCreated([
            'message' => 'Wash order has been created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
