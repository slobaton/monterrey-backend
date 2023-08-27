<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientParameterPriceRequest;
use App\Http\Requests\UpdateClientParameterPriceRequest;
use App\Http\Resources\ClientParameterPriceResource;
use App\Models\ChargeParameter;
use App\Models\ClientParameterPrice;

class ClientParameterPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value);
    }

    public function getPriceById(Client $client, $parameterId, $id)
    {
        $parameterPrice = $client->parameters()
            ->wherePivot('charge_parameter_id', $parameterId)
            ->wherePivot('id', $id)
            ->first();

        if (is_null($parameterPrice)) {
            return $this->respondNotFound('Parameter price not found for the client.');
        }

        return new ClientParameterPriceResource($parameterPrice);
    }

    public function assignPrice(StoreClientParameterPriceRequest $request, Client $client, ChargeParameter $parameter)
    {
        $parameterPrice = ClientParameterPrice::where('client_id', $client->id)
            ->where('charge_parameter_id', $parameter->id)
            ->first();

        if (!is_null($parameterPrice)) {
            return $this->respondError('Parameter price already assigned for the client.');
        }

        ClientParameterPrice::create([
            'client_id' => $client->id,
            'charge_parameter_id' => $parameter->id,
            ...$request->all()
        ]);

        return $this->respondOk('Parameter price assigned.');
    }

    public function updatePrice(UpdateClientParameterPriceRequest $request, Client $client, ChargeParameter $parameter, $id)
    {
        $parameterPrice = ClientParameterPrice::where('client_id', $client->id)
            ->where('charge_parameter_id', $parameter->id)
            ->where('id', $id)
            ->first();

        if (is_null($parameterPrice)) {
            return $this->respondNotFound('Parameter price not found for the client.');
        }

        $parameterPrice->price = $request->price;
        $parameterPrice->save();

        return $this->respondOk('Parameter price updated.');
    }

    public function deletePrice($clientId, $parameterId, $id)
    {
        $parameterPrice = ClientParameterPrice::where('id', $id)
            ->where('client_id', $clientId)
            ->where('charge_parameter_id', $parameterId)
            ->first();

        if (is_null($parameterPrice)) {
            return $this->respondNotFound('Parameter price not found for the client.');
        }

        $parameterPrice->delete();

        return $this->respondNoContent();
    }
}
