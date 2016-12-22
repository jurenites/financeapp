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

class SendSubmittedEmailToRequester
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
            Mail::queue('emails.submitted_to_requester', compact('requestForm'), function ($m) use ($requestForm) {
                $m->to($requestForm->email, $requestForm->name)->subject('Your request form was submitted.');
            });

            $email = new Email;
            $email->subject = 'Your request was submitted.';
            $email->body = View::make('emails.submitted_to_requester', compact('requestForm'))->render();
            $email->to_email = $requestForm->email;
            $email->template = 'emails.submitted_to_requester';
            $email->author_id = Auth::user()->id;
            $email->request_form_id = $requestForm->id;
            $email->save();
        }
    }
}
