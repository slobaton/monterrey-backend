<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Effect;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;

use App\Http\Resources\EffectResource;
use App\Http\Requests\PaginationRequest;
use App\Http\Resources\EffectCollection;
use App\Http\Requests\StoreEffectRequest;
use App\Http\Requests\UpdateEffectRequest;

class EffectController extends Controller
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
    public function index(PaginationRequest $request): EffectCollection
    {
        $effect = QueryBuilder::for(Effect::class)
            ->allowedFilters(Effect::getAllowedFilters())
            ->defaultSort(Effect::getDefaultSort())
            ->allowedSorts(Effect::getAllowedSorts())
            ->allowedIncludes(Effect::getAllowedIncludes());

        $effect = $request->has('page.number') && $request->has('page.size')
            ? $effect->jsonPaginate()
            : $effect->get();

        return new EffectCollection($effect);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEffectRequest $request): JsonResponse
    {
        $user = Effect::create($request->all());

        return $this->respondCreated([
            'message' => 'Effect has been created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Effect $effect): EffectResource
    {
        $effectBuilder = Effect::where('id', $effect->id);

        return new EffectResource(QueryBuilder::for($effectBuilder)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEffectRequest $request, Effect $effect)
    {
        $effect->update($request->all());

        return new EffectResource($effect);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Effect $effect)
    {
        $effect->delete();

        return $this->respondWithSuccess([
            'message' => 'Effect has been deleted'
        ]);
    }
}
