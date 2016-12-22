<?php

namespace App\Listeners;

use App\Events\RequestFormApprovedByAdmin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;

use App\RequestFormEvent;

class AddRequestFormApprovedByAdminEvent
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
     * @param  RequestFormApprovedByAdmin  $event
     * @return void
     */
    public function handle(RequestFormApprovedByAdmin $event)
    {
        $requestFormEvent = new RequestFormEvent;
        $requestFormEvent->author_id = Auth::user()->id;
        $requestFormEvent->request_form_id = $event->requestForm->id;
        $requestFormEvent->type = RequestFormEvent::TYPE_APPROVED;
        $requestFormEvent->save();
    }
}
