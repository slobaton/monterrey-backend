<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientEffectPriceCollection;
use App\Http\Resources\ClientWashTypePriceCollection;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ClientCollection
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
    public function store(StoreClientRequest $request)
    {
        Client::create($request->all());

        return $this->respondCreated([
            'message' => 'Client has been created!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client): ClientResource
    {
        $clientQuery = Client::where('id', $client->id);

        $data = QueryBuilder::for($clientQuery)
            ->allowedIncludes(Client::getAllowedIncludes())
            ->first();

        return new ClientResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client): ClientResource
    {
        $client->update($request->all());

        return new ClientResource($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $this->respondWithSuccess([
            'message' => 'Client has been deleted'
        ]);
    }

    /**
     * Get Client Wash Types
     */
    public function getWashTypes(Request $request, Client $client)
    {
        $washTypes = QueryBuilder::for($client->washTypes());

        $washTypes = $request->has('page.number') && $request->has('page.size')
            ? $washTypes->jsonPaginate()
            : $washTypes->get();

        return new ClientWashTypePriceCollection($washTypes);
    }

    /**
     * Get Client Effects Prices
     */
    public function getEffects(Request $request, Client $client)
    {
        $effects = QueryBuilder::for($client->effects());

        $effects = $request->has('page.number') && $request->has('page.size')
            ? $effects->jsonPaginate()
            : $effects->get();

        return new ClientEffectPriceCollection($effects);
    }
}
