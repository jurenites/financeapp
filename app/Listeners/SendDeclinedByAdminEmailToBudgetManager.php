<?php

namespace App\Listeners;

use App\Events\RequestFormDeclinedByAdmin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use View;
use Auth;

use App\Email;
use App\Role;

class SendDeclinedByAdminEmailToBudgetManager
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
     * @param  RequestFormDeclinedByAdmin  $event
     * @return void
     */
    public function handle(RequestFormDeclinedByAdmin $event)
    {
        $requestForm = $event->requestForm;
        if ($requestForm->requester->hasRole(Role::ROLE_USER)) {
            $note = $requestForm->budgetManagerNotes()->orderBy('created_at', 'desc')->first();
            if ($requestForm->budgetManager) {
                Mail::queue('emails.declined_by_admin_to_budget_manager', compact('requestForm', 'note'), function ($m) use ($requestForm) {
                    $m->to($requestForm->budgetManager->email, $requestForm->budgetManager->name)->subject('Request was declined by Finance Admin.');
                });

                $email = new Email;
                $email->subject = 'Request was declined by Finance Admin.';
                $email->body = View::make('emails.declined_by_admin_to_budget_manager', compact('requestForm', 'note'))->render();
                $email->to_email = $requestForm->budgetManager->email;
                $email->template = 'emails.declined_by_admin_to_budget_manager';
                $email->author_id = Auth::user()->id;
                $email->request_form_id = $requestForm->id;
                $email->save();
            }
        }
    }
}
