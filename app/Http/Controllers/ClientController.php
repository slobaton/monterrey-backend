<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enums\Roles;
use App\Models\Client;
use App\Models\WashOrder;
use Illuminate\Http\Request;
use App\Models\AccountMovement;
use App\Models\WashOrderDetail;
use App\Enums\AccountMovementType;
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
use App\Http\Resources\ClientParameterPriceCollection;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['update', 'destroy']);
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['getWashTypes', 'getEffects', 'getParameters', 'addPaymentMovement', 'addDiscountMovement']);
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
     * Get Client Account Movements by month.
     */
    public function getAccountMovementsByMoth(Request $request, Client $client)
    {
        $currentDate = Date::now();

        $clientId = $client->id;
        $balanceMonth = $request->query('balanceMonth', $currentDate->month);
        $balanceYear = $request->query('balanceYear', $currentDate->year);

        $startBalanceDate = Carbon::createFromDate($balanceYear, $balanceMonth, 1);
        $startBalanceDebt = AccountMovement::getBalanceDebtUntilDate($startBalanceDate, $clientId);
        $movements = AccountMovement::getAccountMovementsByDate($balanceMonth, $balanceYear, $clientId);

        $balanceUntilDate = $startBalanceDebt;

        $accountMovements = $movements->map(function ($movement, int $key) use (&$balanceUntilDate) {
            $balanceDebt = $balanceUntilDate + $movement->amount;

            $accountMovement = [
                'date' => $movement->date,
                'code' => $movement->code,
                'type' => $movement->type,
                'wash_order_id' => $movement->wash_order_id,
                'amount' => (float)$movement->amount,
                'details' => $movement->type == AccountMovementType::CHARGE->value
                    ? WashOrderDetail::getDetailsByOrderId($movement->wash_order_id, $balanceUntilDate)
                    : null,
                'balance_debt' => $balanceDebt
            ];

            $balanceUntilDate = $balanceDebt;

            return $accountMovement;
        });

        $data = [
            'start_balance' => $startBalanceDebt,
            'final_balance' => $balanceUntilDate,
            'movements' => $accountMovements
        ];

        return $this->respondWithSuccess($data);
    }

    /**
     * Add payment movement for the client.
     */
    public function addPaymentMovement(AddPaymentRequest $request, Client $client)
    {
        $receiptNumber = $request->get('receipt_number');
        $amount = $request->get('amount', 0);
        $date = $request->get('date', Date::now()->toDateString());

        $date = Date::parse($date);

        if ($amount <= 0 || $amount > $client->debt_balance) {
            return $this->respondError('invalid amount');
        }

        $paymentCompleted = $client->makePayment($receiptNumber, $amount, $date);

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
        $concept = $request->get('concept');
        $amount = $request->get('amount', 0);
        $date = $request->get('date', Date::now()->toDateString());

        $date = Date::parse($date);

        if ($amount <= 0 || $amount > $client->debt_balance) {
            return $this->respondError('invalid amount');
        }

        $discountCompleted = $client->makeDiscount($concept, $amount, $date);

        if (!$discountCompleted) {
            return $this->respondError('cannot make discount');
        }

        return $this->respondWithSuccess();
    }
}
