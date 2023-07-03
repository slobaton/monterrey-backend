<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\StoreWashTypeRequest;
use App\Http\Requests\UpdateWashTypeRequest;
use App\Http\Resources\WashTypeCollection;
use App\Http\Resources\WashTypeResource;
use App\Models\WashType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class WashTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        $washTypes = QueryBuilder::for(WashType::class)
            ->allowedFilters(WashType::getAllowedFilters())
            ->defaultSort(WashType::getDefaultSort())
            ->allowedSorts(WashType::getAllowedSorts())
            ->allowedIncludes(WashType::getAllowedIncludes());

        $washTypes = $request->has('page.number') && $request->has('page.size')
            ? $washTypes->jsonPaginate()
            : $washTypes->get();

        return new WashTypeCollection($washTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWashTypeRequest $request)
    {
        WashType::create($request->all());

        return $this->respondCreated([
            'message' => 'Wash Type has been created!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(WashType $washType)
    {
        $query = WashType::where('id', $washType->id);

        $data = QueryBuilder::for($query)
            ->allowedIncludes(WashType::getAllowedIncludes())
            ->first();

        return new WashTypeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWashTypeRequest $request, WashType $washType)
    {
        $washType->update($request->all());

        return new WashTypeResource($washType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WashType $washType)
    {
        $washType->delete();

        return $this->respondWithSuccess([
            'message' => 'Wash Type has been deleted'
        ]);
    }
}
