<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Http\Request;
use Datatables;
use View;

use App\RequestForm;

class RequestFormController extends ApiController
{
    protected $currentNamespace = 'Admin';

    public function archive(Request $request)
    {
        $requestForms = RequestForm::whereIn('status', [RequestForm::STATUS_COMPLETED])
            ->orWhereNotNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->with('requester')
            ->with('budgetManager')
            ->with('budgetCategory')
            ->withTrashed()
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return Datatables::of($requestForms)
                ->editColumn('status', function ($requestForm) {
                    if ($requestForm->deleted_at) {
                        $requestForm->status = RequestForm::STATUS_DELETED;
                    }
                    return view('shared.partials._request_form_status', $requestForm);
                })
                ->editColumn('created_at', '{!! $created_at->format("m/d/Y") !!}')
                ->editColumn('budget_manager', function ($requestForm) {
                    return $requestForm->budgetManager ? (array)json_decode($requestForm->budgetManager) : array('name' => '');
                })
                ->editColumn('budget_category', function ($requestForm) {
                    return $requestForm->budgetCategory ? (array)json_decode($requestForm->budgetCategory) : array('name' => '');
                })
                ->addColumn('actions', function ($requestForm) {
                    return view('shared.partials._archive_actions', $requestForm);
                })
                ->addColumn('export', function ($requestForm) {
                    return view('shared.partials._archive_export', $requestForm);
                })
                ->make(true);
        }
    }
}
