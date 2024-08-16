<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\PaginationRequest;
use App\Models\ClothSize;
use App\Http\Requests\StoreClothSizeRequest;
use App\Http\Requests\UpdateClothSizeRequest;
use App\Http\Resources\ClothSizeCollection;
use App\Http\Resources\ClothSizeResource;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ClothSizeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value)
            ->only(['update', 'destroy']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value)
            ->only(['store']);

        $this->middleware('role:' . Roles::ADMIN->value . ',' . Roles::SECRETARY->value . ',' . Roles::RECEPTIONIST->value)
            ->only(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request)
    {
        $clothSizes = QueryBuilder::for(ClothSize::class)
            ->allowedFilters(ClothSize::getAllowedFilters())
            ->defaultSort(ClothSize::getDefaultSort())
            ->allowedSorts(ClothSize::getAllowedSorts())
            ->allowedIncludes(ClothSize::getAllowedIncludes());

        $clothSizes = $request->has('page.number') && $request->has('page.size')
            ? $clothSizes->jsonPaginate()
            : $clothSizes->get();

        return new ClothSizeCollection($clothSizes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClothSizeRequest $request)
    {
        ClothSize::create($request->all());

        return $this->respondCreated([
            'message' => 'Cloth Size has been created!'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ClothSize $clothSize)
    {
        $query = ClothSize::where('id', $clothSize->id);

        $data = QueryBuilder::for($query)
            ->allowedIncludes(ClothSize::getAllowedIncludes())
            ->first();

        return new ClothSizeResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClothSizeRequest $request, ClothSize $clothSize)
    {
        $clothSize->update($request->all());

        return new ClothSizeResource($clothSize);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClothSize $clothSize)
    {
        $clothSize->delete();

        return $this->respondWithSuccess([
            'message' => 'Cloth Size has been deleted'
        ]);
    }
}
