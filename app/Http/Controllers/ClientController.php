<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\AddPaymentRequest;
use App\Models\Client;
use App\Models\WashOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ClientCollection;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientEffectPriceCollection;
use App\Http\Resources\ClientWashTypePriceCollection;
use App\Http\Resources\ClientParameterPriceCollection;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['update', 'destroy']);
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['getWashTypes', 'getEffects', 'getParameters']);
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value . ',' . Roles::RECEPTIONIST->value)
            ->only(['index', 'store', 'show']);
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
        $createdClient = Client::create($request->all());

        return new ClientResource($createdClient);
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

    /**
     * Get Client Parameter Prices
     */
    public function getParameters(Request $request, Client $client)
    {
        $parameters = QueryBuilder::for($client->parameters());

        $parameters = $request->has('page.number') && $request->has('page.size')
            ? $parameters->jsonPaginate()
            : $parameters->get();

        return new ClientParameterPriceCollection($parameters);
    }

    /**
     * Add payment for the client to an specific wash order.
     */
    public function addPaymentForWashOrder(AddPaymentRequest $request, Client $client, WashOrder $washOrder)
    {
        if ($client->id !== $washOrder->client_id) {
            return $this->respondForbidden();
        }

        $amount = $request->get('amount', 0);
        $date = $request->get('date', Date::now());

        if ($amount <= 0 || $amount > $washOrder->debt_balance) {
            return $this->respondError('invalid amount');
        }

        $paymentCompleted = $washOrder->makePayment($amount, $date);

        if (!$paymentCompleted) {
            return $this->respondError('cannot make payment');
        }

        return $this->respondWithSuccess();
    }
}
