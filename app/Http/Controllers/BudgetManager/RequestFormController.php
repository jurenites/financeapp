<?php

namespace App\Http\Controllers\BudgetManager;

use App\Http\Controllers\Shared;

use Auth;
use Event;
use Illuminate\Http\Request;

use App\RequestForm;
use App\User;
use App\Note;
use App\Events\RequestFormApprovedByManager;
use App\Events\RequestFormDeclinedByManager;

class RequestFormController extends Shared\RequestFormController
{
    protected $currentNamespace = 'BudgetManager';

    protected function getRequestForms()
    {
        $requestForms = Auth::user()->assignedRequestForms()
            ->whereNotIn('status', [RequestForm::STATUS_COMPLETED, RequestForm::STATUS_DECLINED_BY_MANAGER]);
        return $requestForms;
    }

    protected function getReportRequestForms($from, $to, $status)
    {
        $requestForms = Auth::user()->assignedRequestForms()
            ->whereBetween('created_at', [$from, $to])
            ->whereStatus($status)
            ->orderBy('created_at', 'desc')
            ->get();

        return $requestForms;
    }

    protected function isCanView($requestForm)
    {
        return Auth::user()->id == $requestForm->budget_manager_id;
    }

    protected function isCanEdit($requestForm)
    {
        return Auth::user()->id == $requestForm->budget_manager_id;
    }

    protected function isCanAddRequesterNote($requestForm)
    {
        return Auth::user()->id == $requestForm->budget_manager_id;
    }

    protected function isCanApprove($requestForm)
    {
        return Auth::user()->id == $requestForm->budget_manager_id &&
            $requestForm->isManagerCanApprove();
    }

    protected function getApprovalStatus()
    {
        return RequestForm::STATUS_APPROVED_BY_MANAGER;
    }

    protected function emitApproveEvent($requestForm)
    {
        Event::fire(new RequestFormApprovedByManager($requestForm));
    }

    protected function isCanDecline($requestForm)
    {
        return Auth::user()->id == $requestForm->budget_manager_id &&
            $requestForm->isManagerCanDecline();
    }

    protected function getDeclineNoteType()
    {
        return Note::TYPE_REQUESTER;
    }

    protected function getDeclineStatus()
    {
        return RequestForm::STATUS_DECLINED_BY_MANAGER;
    }

    protected function emitDeclineEvent($requestForm)
    {
        Event::fire(new RequestFormDeclinedByManager($requestForm));
    }

    protected function getAvailableBudgetManagers()
    {
        return [Auth::user()];
    }
}
