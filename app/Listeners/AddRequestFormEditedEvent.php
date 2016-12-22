<?php

namespace App\Listeners;

use App\Events\RequestFormEdited;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;

use App\RequestFormEvent;

class AddRequestFormEditedEvent
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
     * @param  RequestFormEdited  $event
     * @return void
     */
    public function handle(RequestFormEdited $event)
    {
        $requestFormEvent = new RequestFormEvent;
        $requestFormEvent->author_id = Auth::user()->id;
        $requestFormEvent->request_form_id = $event->requestForm->id;
        $requestFormEvent->type = RequestFormEvent::TYPE_EDITED;
        $requestFormEvent->save();
    }
}
