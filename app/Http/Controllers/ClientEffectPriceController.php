<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use App\Models\Effect;
use Illuminate\Http\Request;
use App\Models\ClientEffectPrice;
use App\Http\Resources\ClientEffectPriceResource;
use App\Http\Requests\StoreClientEffectPriceRequest;
use App\Http\Requests\UpdateClientEffectPriceRequest;

class ClientEffectPriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['updatePrice', 'deletePrice']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['assignPrice']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value . ',' . Roles::RECEPTIONIST->value)
            ->only(['getPriceById']);
    }

    public function getPriceById(Client $client, $effectId, $id)
    {
        $effectPrice = $client->effects()
            ->wherePivot('effect_id', $effectId)
            ->wherePivot('id', $id)
            ->first();

        if (is_null($effectPrice)) {
            return $this->respondNotFound('Effect price not found for the client.');
        }

        return new ClientEffectPriceResource($effectPrice);
    }

    public function assignPrice(StoreClientEffectPriceRequest $request, Client $client, Effect $effect)
    {
        $effectPrice = ClientEffectPrice::where('client_id', $client->id)
            ->where('effect_id', $effect->id)
            ->first();

        if (!is_null($effectPrice)) {
            return $this->respondError('Effect price already assigned for the client.');
        }

        ClientEffectPrice::create([
            'client_id' => $client->id,
            'effect_id' => $effect->id,
            ...$request->all()
        ]);

        return $this->respondOk('Effect price assigned.');
    }

    public function updatePrice(UpdateClientEffectPriceRequest $request, Client $client, Effect $effect, $id)
    {
        $effectPrice = ClientEffectPrice::where('client_id', $client->id)
            ->where('effect_id', $effect->id)
            ->where('id', $id)
            ->first();

        if (is_null($effectPrice)) {
            return $this->respondNotFound('Effect price not found for the client.');
        }

        $effectPrice->price = $request->price;
        $effectPrice->save();

        return $this->respondOk('Effect price updated.');
    }

    public function deletePrice($clientId, $effectId, $id)
    {
        $effectPrice = ClientEffectPrice::where('id', $id)
            ->where('client_id', $clientId)
            ->where('effect_id', $effectId)
            ->first();

        if (is_null($effectPrice)) {
            return $this->respondNotFound('Effect price not found for the client.');
        }

        $effectPrice->delete();

        return $this->respondNoContent();
    }
}
