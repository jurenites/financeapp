<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Shared;

use Auth;
use Event;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Datatables;

use App\RequestForm;
use App\User;
use App\Note;
use App\Events\RequestFormApprovedByAdmin;
use App\Events\RequestFormDeclinedByAdmin;
use App\Events\RequestFormCompleted;

class RequestFormController extends Shared\RequestFormController
{
    protected $currentNamespace = 'Admin';

    public function pay(Request $request, $id)
    {
        $requestForm = RequestForm::findOrFail($id);

        if (!$requestForm->isAdminCanPay()) {
            return back();
        }

        $requestForm->status = RequestForm::STATUS_COMPLETED;
        $requestForm->status_changed_at = Carbon::now();
        $requestForm->save();

        Event::fire(new RequestFormCompleted($requestForm));

        $request->session()->flash('success', 'Request form completed.');

        return back();
    }

    protected function getRequestForms()
    {
        $requestForms = RequestForm::where('status', '!=', RequestForm::STATUS_COMPLETED)
            ->orderBy('created_at', 'desc');
        return $requestForms;
    }

    protected function getReportRequestForms($from, $to, $status)
    {
        $requestForms = RequestForm::whereBetween('created_at', [$from, $to])
            ->whereStatus($status)
            ->orderBy('created_at', 'desc')
            ->get();

        return $requestForms;
    }

    protected function isCanView($requestForm)
    {
        return true;
    }

    protected function isCanEdit($requestForm)
    {
        return true;
    }

    protected function isCanDestroy($requestForm)
    {
        return true;
    }

    protected function isCanAddRequesterNote($requestForm)
    {
        return true;
    }

    protected function isCanAddBudgetManagerNote($requestForm)
    {
        return true;
    }

    protected function isCanAddAdminNote($requestForm)
    {
        return true;
    }

    protected function isCanApprove($requestForm)
    {
        return $requestForm->isAdminCanApprove();
    }

    protected function isCanExport($requestForm)
    {
        return true;
    }

    protected function getApprovalStatus()
    {
        return RequestForm::STATUS_APPROVED_BY_ADMIN;
    }

    protected function emitApproveEvent($requestForm)
    {
        Event::fire(new RequestFormApprovedByAdmin($requestForm));
    }

    protected function isCanDecline($requestForm)
    {
        return $requestForm->isAdminCanDecline();
    }

    protected function getDeclineNoteType()
    {
        return Note::TYPE_BUDGET_MANAGER;
    }

    protected function getDeclineStatus()
    {
        return RequestForm::STATUS_DECLINED_BY_ADMIN;
    }

    protected function emitDeclineEvent($requestForm)
    {
        Event::fire(new RequestFormDeclinedByAdmin($requestForm));
    }
}
