<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class UserPasswordController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return $this->respondForbidden('Current password is incorrect');
        }

        $user->password = $request->new_password;
        $user->save();

        return $this->respondWithSuccess([
            'message' => 'Password successfully updated'
        ]);
    }
}
