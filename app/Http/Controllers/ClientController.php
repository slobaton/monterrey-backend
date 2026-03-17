<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\AccountMovement;
use App\Http\Requests\AddDiscountRequest;
use Illuminate\Support\Facades\Date;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\ClientResource;
use App\Http\Requests\AddPaymentRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientEffectPriceCollection;
use App\Http\Resources\ClientWashTypePriceCollection;
use App\Http\Resources\ClientParameterValueCollection;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['update', 'destroy']);
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['getWashTypes', 'getEffects', 'getParameters', 'getAccountMovements', 'addPaymentMovement', 'addDiscountMovement']);
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

        return new ClientParameterValueCollection($parameters);
    }

    /**
     * Get Client Account Movements by month.
     */
    public function getAccountMovements(Request $request, Client $client)
    {
        $clientId = $client->id;

        $movements = AccountMovement::getAccountMovements($clientId);

        $startDate = AccountMovement::getAccountMovementsStartDate($clientId);
        $endDate = AccountMovement::getAccountMovementsEndDate($clientId);

        $balance = 0;
        $detailedMovements = AccountMovement::getDetailedMovements($movements, $balance);

        $data = [
            'start_balance' => 0,
            'final_balance' => $balance,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'movements' => $detailedMovements
        ];

        return $this->respondWithSuccess($data);
    }

    /**
     * Add payment movement for the client.
     */
    public function addPaymentMovement(AddPaymentRequest $request, Client $client)
    {
        $userId = $request->user()->id;
        $receiptNumber = $request->get('receipt_number');
        $amount = $request->get('amount', 0);
        $date = $request->get('date', Date::now()->toDateString());

        $date = Date::parse($date);

        $paymentCompleted = $client->makePayment($receiptNumber, $amount, $date, $userId);

        if (!$paymentCompleted) {
            return $this->respondError('cannot make payment');
        }

        return $this->respondWithSuccess();
    }

    /**
     * Add payment movement for the client.
     */
    public function addDiscountMovement(AddDiscountRequest $request, Client $client)
    {
        $userId = $request->user()->id;
        $receiptNumber = $request->get('receipt_number');
        $concept = $request->get('concept');
        $amount = $request->get('amount', 0);
        $date = $request->get('date', Date::now()->toDateString());

        $date = Date::parse($date);

        $discountCompleted = $client->makeDiscount($receiptNumber, $concept, $amount, $date, $userId);

        if (!$discountCompleted) {
            return $this->respondError('cannot make discount');
        }

        return $this->respondWithSuccess();
    }

}
