<?php

namespace App\Listeners;

use App\Events\RequestFormDeclinedByAdmin;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;

use App\RequestFormEvent;

class AddRequestFormDeclinedByAdminEvent
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
        $requestFormEvent = new RequestFormEvent;
        $requestFormEvent->author_id = Auth::user()->id;
        $requestFormEvent->request_form_id = $event->requestForm->id;
        $requestFormEvent->type = RequestFormEvent::TYPE_DECLINED;
        $requestFormEvent->save();
    }
}
