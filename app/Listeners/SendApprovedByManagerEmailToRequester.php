<?php

namespace App\Listeners;

use App\Events\RequestFormApprovedByManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use View;
use Auth;

use App\Email;
use App\Role;

class SendApprovedByManagerEmailToRequester
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
     * @param  RequestFormApprovedByManager  $event
     * @return void
     */
    public function handle(RequestFormApprovedByManager $event)
    {
        $requestForm = $event->requestForm;
        if ($requestForm->requester->hasRole(Role::ROLE_USER)) {
            Mail::queue('emails.approved_by_budget_manager_to_requester', compact('requestForm'), function ($m) use ($requestForm) {
                $m->to($requestForm->email, $requestForm->name)->subject('Request was approved.');
            });

            $email = new Email;
            $email->subject = 'Request was approved.';
            $email->body = View::make('emails.approved_by_budget_manager_to_requester', compact('requestForm'))->render();
            $email->to_email = $requestForm->email;
            $email->template = 'emails.approved_by_budget_manager_to_requester';
            $email->author_id = Auth::user()->id;
            $email->request_form_id = $requestForm->id;
            $email->save();
        }
    }
}
