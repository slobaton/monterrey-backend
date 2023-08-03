<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use App\Models\WashType;
use Illuminate\Http\Request;
use App\Models\ClientWashTypePrice;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreClientWashTypePriceRequest;
use App\Http\Requests\UpdateClientWashTypePriceRequest;

class ClientWashTypePriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value);
    }

    public function getPrices(Request $request, $clientId, $washTypeId)
    {
        $query = ClientWashTypePrice::where('client_id', $clientId)
            ->where('wash_type_id', $washTypeId);

        $washTypePrices = QueryBuilder::for($query)
            ->allowedFilters(ClientWashTypePrice::getAllowedFilters())
            ->defaultSort(ClientWashTypePrice::getDefaultSort())
            ->allowedSorts(ClientWashTypePrice::getAllowedSorts())
            ->allowedIncludes(ClientWashTypePrice::getAllowedIncludes());

        $washTypePrices = $request->has('page.number') && $request->has('page.size')
            ? $washTypePrices->jsonPaginate()
            : $washTypePrices->get();

        return $this->respondWithSuccess($washTypePrices);
    }

    public function getPriceById($clientId, $washTypeId, $id)
    {
        $query = ClientWashTypePrice::where('id', $id)
            ->where('client_id', $clientId)
            ->where('wash_type_id', $washTypeId);

        $washTypePrice = QueryBuilder::for($query)
            ->allowedIncludes(ClientWashTypePrice::getAllowedIncludes())
            ->first();

        if (is_null($washTypePrice)) {
            return $this->respondNotFound('Wash type price not found for the client.');
        }

        return $this->respondWithSuccess([
            'data' => $washTypePrice
        ]);
    }

    public function assignPrice(StoreClientWashTypePriceRequest $request, Client $client, WashType $washType)
    {
        $washTypePrice = ClientWashTypePrice::where('client_id', $client->id)
            ->where('wash_type_id', $washType->id)
            ->first();

        if (!is_null($washTypePrice)) {
            return $this->respondError('Wash price already assigned for the client.');
        }

        ClientWashTypePrice::create([
            'client_id' => $client->id,
            'wash_type_id' => $washType->id,
            ...$request->all()
        ]);

        return $this->respondOk('Wash type price assigned.');
    }

    public function updatePrice(UpdateClientWashTypePriceRequest $request, Client $client, WashType $washType, $id)
    {
        $washTypePrice = ClientWashTypePrice::where('client_id', $client->id)
            ->where('wash_type_id', $washType->id)
            ->where('id', $id)
            ->first();

        if (is_null($washTypePrice)) {
            return $this->respondNotFound('Wash type price not found for the client.');
        }

        $washTypePrice->price = $request->price;
        $washTypePrice->save();

        return $this->respondOk('Wash type price updated.');
    }

    public function deletePrice($clientId, $washTypeId, $id)
    {
        $washTypePrice = ClientWashTypePrice::where('id', $id)
            ->where('client_id', $clientId)
            ->where('wash_type_id', $washTypeId)
            ->first();

        if (is_null($washTypePrice)) {
            return $this->respondNotFound('Wash type price not found for the client.');
        }

        $washTypePrice->delete();

        return $this->respondNoContent();
    }
}
