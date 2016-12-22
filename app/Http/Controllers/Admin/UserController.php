<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Shared;

use Auth;

use App\User;

class UserController extends Shared\UserController
{
    protected $currentNamespace = 'Admin';

    protected function getUsers()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return $users;
    }

    protected function isCanStore($user)
    {
        return true;
    }

    protected function isCanEdit($user)
    {
        return true;
    }

    protected function isCanDestroy($user)
    {
        return true;
    }

    protected function isCanSetBudgetCategories($user)
    {
        return true;
    }
}
