<?php

namespace App\Listeners;

use App\Events\RequestFormPendingBudgetManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use View;
use Auth;

use App\Email;
use App\User;
use App\Role;

class SendPendingRequestFormEmailToBudgetManager
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RequestFormPendingBudgetManager  $event
     * @return void
     */
    public function handle(RequestFormPendingBudgetManager $event)
    {
        $requestForm = $event->requestForm;
        if ($requestForm->requester->hasRole(Role::ROLE_USER)) {
            if ($requestForm->budgetManager) {
                Mail::queue('emails.pending_to_budget_manager', compact('requestForm'), function ($m) use ($requestForm) {
                    $m->to($requestForm->budgetManager->email, $requestForm->budgetManager->name)->subject('Request form is pending.');
                });

                $email = new Email;
                $email->subject = 'Request form is pending.';
                $email->body = View::make('emails.pending_to_budget_manager', compact('requestForm'))->render();
                $email->to_email = $requestForm->budgetManager->email;
                $email->template = 'emails.pending_to_budget_manager';
                $email->author_id = User::first()->id;
                $email->request_form_id = $requestForm->id;
                $email->save();
            }
        }
    }
}
