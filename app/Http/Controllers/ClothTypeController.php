<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\PaginationRequest;
use App\Models\ClothType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\StoreClothTypeRequest;
use App\Http\Requests\UpdateClothTypeRequest;
use App\Http\Resources\ClothTypeCollection;
use App\Http\Resources\ClothTypeResource;

class ClothTypeController extends Controller
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
        $clothTypes = QueryBuilder::for(ClothType::class)
            ->allowedFilters(ClothType::getAllowedFilters())
            ->defaultSort(ClothType::getDefaultSort())
            ->allowedSorts(ClothType::getAllowedSorts())
            ->allowedIncludes(ClothType::getAllowedIncludes());

        $clothTypes = $request->has('page.number') && $request->has('page.size')
            ? $clothTypes->jsonPaginate()
            : $clothTypes->get();

        return new ClothTypeCollection($clothTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClothTypeRequest $request)
    {
        ClothType::create($request->all());

        return $this->respondCreated([
            'message' => 'Cloth Type has been created!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClothType $clothType)
    {
        $query = ClothType::where('id', $clothType->id);

        $data = QueryBuilder::for($query)
            ->allowedIncludes(ClothType::getAllowedIncludes())
            ->first();

        return new ClothTypeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClothTypeRequest $request, ClothType $clothType)
    {
        $clothType->update($request->all());

        return new ClothTypeResource($clothType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClothType $clothType)
    {
        $clothType->delete();

        return $this->respondWithSuccess([
            'message' => 'Cloth Type has been deleted'
        ]);
    }
}
