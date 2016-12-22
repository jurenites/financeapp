<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Shared;

use Auth;

class DocumentController extends Shared\DocumentController
{
    protected $currentNamespace = 'User';

    protected function isCanDownload($document)
    {
        return Auth::user()->id == $document->requestForm->user_id;
    }

    protected function isCanDestroy($document)
    {
        return Auth::user()->id == $document->requestForm->user_id;
    }
}
