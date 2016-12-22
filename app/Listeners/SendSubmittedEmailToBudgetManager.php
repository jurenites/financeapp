<?php

namespace App\Listeners;

use App\Events\RequestFormSubmitted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use View;
use Auth;

use App\Email;
use App\Role;

class SendSubmittedEmailToBudgetManager
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
     * @param  RequestFormSubmitted  $event
     * @return void
     */
    public function handle(RequestFormSubmitted $event)
    {
        $requestForm = $event->requestForm;
        if ($requestForm->requester->hasRole(Role::ROLE_USER)) {
            if ($requestForm->budgetManager) {
                $actionToken = $requestForm->budgetManager->actionTokens()->whereRequestFormId($requestForm->id)->orderBy('created_at', 'desc')->first();

                Mail::queue('emails.submitted_to_budget_manager', compact('requestForm', 'actionToken'), function ($m) use ($requestForm) {
                    $m->to($requestForm->budgetManager->email, $requestForm->budgetManager->name)->subject('New request form was submitted.');
                });

                $email = new Email;
                $email->subject = 'New request form was submitted.';
                $email->body = View::make('emails.submitted_to_budget_manager', compact('requestForm', 'actionToken'))->render();
                $email->to_email = $requestForm->budgetManager->email;
                $email->template = 'emails.submitted_to_budget_manager';
                $email->author_id = Auth::user()->id;
                $email->request_form_id = $requestForm->id;
                $email->save();
            }
        }
    }
}
