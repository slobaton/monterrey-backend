<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateSystemParameterRequest;
use App\Http\Resources\SystemParameterCollection;
use App\Http\Resources\SystemParameterResource;
use App\Models\SystemParameter;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class SystemParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['update']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        $paramaters = QueryBuilder::for(SystemParameter::class);

        $paramaters = $request->has('page.number') && $request->has('page.size')
            ? $paramaters->jsonPaginate()
            : $paramaters->get();

        return new SystemParameterCollection($paramaters);
    }

    /**
     * Display the specified resource.
     */
    public function show(SystemParameter $parameter)
    {
        $query = SystemParameter::where('id', $parameter->id);

        $data = QueryBuilder::for($query)
            ->first();

        return new SystemParameterResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSystemParameterRequest $request, SystemParameter $parameter)
    {
        $parameter->update($request->all());

        return new SystemParameterResource($parameter);
    }

}
