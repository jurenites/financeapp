<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Mail;

use App\RequestForm;

use App\Services\Pdf\AbstractPdfConverter;

class DebugController extends Controller
{
    protected $currentNamespace = 'Admin';

    public function index()
    {
    }
}
