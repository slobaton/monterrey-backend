<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): RoleCollection
    {
        return new RoleCollection(Role::all());
    }
}
