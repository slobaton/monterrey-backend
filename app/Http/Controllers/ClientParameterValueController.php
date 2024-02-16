<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\StoreClientParameterValueRequest;
use App\Http\Requests\UpdateClientParameterValueRequest;
use App\Http\Resources\ClientParameterValueResource;
use App\Models\SystemParameter;
use App\Models\ClientParameterValue;

class ClientParameterValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['updateValue', 'deleteValue']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['assignValue']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value . ',' . Roles::RECEPTIONIST->value)
            ->only(['getValueById']);
    }

    public function getValueById(Client $client, $parameterId, $id)
    {
        $parameterValue = $client->parameters()
            ->wherePivot('system_parameter_id', $parameterId)
            ->wherePivot('id', $id)
            ->first();

        if (is_null($parameterValue)) {
            return $this->respondNotFound('Parameter value not found for the client.');
        }

        return new ClientParameterValueResource($parameterValue);
    }

    public function assignValue(StoreClientParameterValueRequest $request, Client $client, SystemParameter $parameter)
    {
        $parameterValue = ClientParameterValue::where('client_id', $client->id)
            ->where('system_parameter_id', $parameter->id)
            ->first();

        if (!is_null($parameterValue)) {
            return $this->respondError('Parameter value already assigned for the client.');
        }

        ClientParameterValue::create([
            'client_id' => $client->id,
            'system_parameter_id' => $parameter->id,
            ...$request->all()
        ]);

        return $this->respondOk('Parameter value assigned.');
    }

    public function updateValue(UpdateClientParameterValueRequest $request, Client $client, SystemParameter $parameter, $id)
    {
        $parameterValue = ClientParameterValue::where('client_id', $client->id)
            ->where('system_parameter_id', $parameter->id)
            ->where('id', $id)
            ->first();

        if (is_null($parameterValue)) {
            return $this->respondNotFound('Parameter value not found for the client.');
        }

        $parameterValue->value = $request->value;
        $parameterValue->save();

        return $this->respondOk('Parameter value updated.');
    }

    public function deleteValue($clientId, $parameterId, $id)
    {
        $parameterValue = ClientParameterValue::where('id', $id)
            ->where('client_id', $clientId)
            ->where('system_parameter_id', $parameterId)
            ->first();

        if (is_null($parameterValue)) {
            return $this->respondNotFound('Parameter value not found for the client.');
        }

        $parameterValue->delete();

        return $this->respondNoContent();
    }
}
