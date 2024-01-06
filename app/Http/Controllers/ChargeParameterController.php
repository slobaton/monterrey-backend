<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateChargeParameterRequest;
use App\Http\Resources\ChargeParameterCollection;
use App\Http\Resources\ChargeParameterResource;
use App\Models\ChargeParameter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ChargeParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        $paramaters = QueryBuilder::for(ChargeParameter::class);

        $paramaters = $request->has('page.number') && $request->has('page.size')
            ? $paramaters->jsonPaginate()
            : $paramaters->get();

        return new ChargeParameterCollection($paramaters);
    }

    /**
     * Display the specified resource.
     */
    public function show(ChargeParameter $parameter)
    {
        $query = ChargeParameter::where('id', $parameter->id);

        $data = QueryBuilder::for($query)
            ->first();

        return new ChargeParameterResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChargeParameterRequest $request, ChargeParameter $parameter)
    {
        $parameter->update($request->all());

        return new ChargeParameterResource($parameter);
    }
}
