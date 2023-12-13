<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\UserCollection;

use App\Http\Requests\StoreUserRequest;

use App\Http\Requests\PaginationRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PaginationRequest $request): UserCollection
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(User::getAllowedFilters())
            ->defaultSort(User::getDefaultSort())
            ->allowedSorts(User::getAllowedSorts())
            ->allowedIncludes(User::getAllowedIncludes());

        $users = $request->has('page.number') && $request->has('page.size')
            ? $users->jsonPaginate()
            : $users->get();

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        User::create($request->all());

        return $this->respondCreated([
            'message' => 'User has been created',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        $userBuilder = User::where('id', $user->id);

        $data = QueryBuilder::for($userBuilder)
            ->allowedIncludes(User::getAllowedIncludes())
            ->first();

        return new UserResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        $user->update($user->checkBeforeUpdatePassword($request));

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->respondWithSuccess([
            'message' => 'User has been deleted'
        ]);
    }
}
