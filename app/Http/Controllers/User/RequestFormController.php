<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Shared;

use Auth;

class RequestFormController extends Shared\RequestFormController
{
    protected $currentNamespace = 'User';

    protected function getRequestForms()
    {
        $requestForms = Auth::user()->createdRequestForms();
        return $requestForms;
    }

    protected function isCanView($requestForm)
    {
        return Auth::user()->id == $requestForm->user_id;
    }

    protected function isCanEdit($requestForm)
    {
        return Auth::user()->id == $requestForm->user_id &&
            $requestForm->isUserCanEdit();
    }
}
