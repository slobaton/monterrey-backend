<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use App\Models\WashType;
use Illuminate\Http\Request;
use App\Models\ClientWashTypePrice;
use App\Http\Requests\StoreClientWashTypePriceRequest;
use App\Http\Requests\UpdateClientWashTypePriceRequest;
use App\Http\Resources\ClientWashTypePriceResource;

class ClientWashTypePriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value);
    }

    public function getPriceById(Client $client, $washTypeId, $id)
    {
        $washTypePrice = $client->washTypes()
            ->wherePivot('wash_type_id', $washTypeId)
            ->wherePivot('id', $id)
            ->as('wash_type_price')
            ->first();

        if (is_null($washTypePrice)) {
            return $this->respondNotFound('Wash type price not found for the client.');
        }

        return new ClientWashTypePriceResource($washTypePrice);
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
