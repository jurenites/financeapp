<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Shared;

use Auth;

class UserController extends Shared\UserController
{
    protected $currentNamespace = 'User';

    protected function isCanEdit($user)
    {
        return Auth::user()->id == $user->id;
    }
}
