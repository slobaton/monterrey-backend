<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientCollection;
use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = QueryBuilder::for(Client::class)
            ->allowedFilters(Client::getAllowedFilters())
            ->defaultSort(Client::getDefaultSort())
            ->allowedSorts(Client::getAllowedSorts())
            ->allowedIncludes(Client::getAllowedIncludes());

        $clients = $request->has('page.number') && $request->has('page.size')
            ? $clients->jsonPaginate()
            : $clients->get();

        return new ClientCollection($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
