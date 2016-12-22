<?php

namespace App\Http\Controllers\Api\BudgetManager;

use App\Http\Controllers\Api\ApiController;

use Illuminate\Http\Request;
use Datatables;
use View;

use App\RequestForm;
use App\User;

class RequestFormController extends ApiController
{
    protected $currentNamespace = 'BudgetManager';

    public function archive(Request $request, $user_id)
    {
        $user = User::findOrFail($user_id);
        $requestForms = $user->assignedRequestForms()
            ->whereIn('status', [RequestForm::STATUS_COMPLETED, RequestForm::STATUS_DECLINED_BY_MANAGER])
            ->orderBy('created_at', 'desc')
            ->with('requester')
            ->with('budgetCategory')
            ->get();

        if ($request->ajax() || $request->wantsJson()) {
            return Datatables::of($requestForms)
                ->editColumn('status', function ($requestForm) {
                    return view('shared.partials._request_form_status', $requestForm);
                })
                ->editColumn('created_at', '{!! $created_at->format("m/d/Y") !!}')
                ->editColumn('budget_category', function ($requestForm) {
                    return $requestForm->budgetCategory ? (array)json_decode($requestForm->budgetCategory) : array('name' => '');
                })
                ->addColumn('actions', function ($requestForm) {
                    return view('shared.partials._archive_actions', $requestForm);
                })
                ->make(true);
        }
    }
}
