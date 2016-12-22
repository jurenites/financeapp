<?php

namespace App\Http\Controllers\BudgetManager;

use App\Http\Controllers\Shared;

use Auth;

use App\Role;

class UserController extends Shared\UserController
{
    protected $currentNamespace = 'BudgetManager';

    protected function isCanEdit($user)
    {
        return Auth::user()->id == $user->id;
    }

    protected function isCanSetBudgetCategories($user)
    {
        return Auth::user()->id == $user->id;
    }
}
