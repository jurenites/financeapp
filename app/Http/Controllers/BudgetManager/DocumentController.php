<?php

namespace App\Http\Controllers\BudgetManager;

use App\Http\Controllers\Shared;

use Auth;

class DocumentController extends Shared\DocumentController
{
    protected $currentNamespace = 'BudgetManager';

    protected function isCanDownload($document)
    {
        return Auth::user()->id == $document->requestForm->budget_manager_id;
    }

    protected function isCanDestroy($document)
    {
        return Auth::user()->id == $document->requestForm->budget_manager_id;
    }
}
