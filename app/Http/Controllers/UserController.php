<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        return response()->json($this->doAction(UserResource::CREATE_USER, false, $request));
    }
}
