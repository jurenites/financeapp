<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Shared;

class DocumentController extends Shared\DocumentController
{
    protected $currentNamespace = 'Admin';

    protected function isCanDownload($document)
    {
        return true;
    }

    protected function isCanDestroy($document)
    {
        return true;
    }
}
