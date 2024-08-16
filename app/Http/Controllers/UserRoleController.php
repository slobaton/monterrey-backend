<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Http\Requests\RoleAssignmentRequest;
use App\Http\Resources\RoleCollection;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:' . Roles::ADMIN->value);
    }

    public function assignRoles(User $user, RoleAssignmentRequest $request): JsonResponse
    {
        $roleIds = $request->input('role_ids');

        $user->roles()->sync($roleIds);

        return $this->respondWithSuccess([
            'message' => 'Roles successfully assigned',
        ]);
    }

    public function getUserRoles(User $user): RoleCollection
    {
        $roles = $user->roles;
        return new RoleCollection($roles);
    }
}
