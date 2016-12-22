<?php

namespace App\Listeners;

use App\Events\RequestFormDeclinedByManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use View;
use Auth;

use App\Email;
use App\Role;

class SendDeclinedByBudgetManagerEmailToRequester
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
     * @param  RequestFormDeclinedByManager  $event
     * @return void
     */
    public function handle(RequestFormDeclinedByManager $event)
    {
        $requestForm = $event->requestForm;
        if ($requestForm->requester->hasRole(Role::ROLE_USER)) {
            $note = $requestForm->requesterNotes()->orderBy('created_at', 'desc')->first();
            Mail::queue('emails.declined_by_budget_manager_to_requester', compact('requestForm', 'note'), function ($m) use ($requestForm) {
                $m->to($requestForm->email, $requestForm->name)->subject('Your request was declined.');
            });

            $email = new Email;
            $email->subject = 'Your request was declined.';
            $email->body = View::make('emails.declined_by_budget_manager_to_requester', compact('requestForm', 'note'))->render();
            $email->to_email = $requestForm->email;
            $email->template = 'emails.declined_by_budget_manager_to_requester';
            $email->author_id = Auth::user()->id;
            $email->request_form_id = $requestForm->id;
            $email->save();
        }
    }
}
