<?php

namespace App\Listeners;

use App\Events\RequestFormCompleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;

use App\RequestFormEvent;

class AddRequestFormCompletedEvent
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
     * @param  RequestFormCompleted  $event
     * @return void
     */
    public function handle(RequestFormCompleted $event)
    {
        $requestFormEvent = new RequestFormEvent;
        $requestFormEvent->author_id = Auth::user()->id;
        $requestFormEvent->request_form_id = $event->requestForm->id;
        $requestFormEvent->type = RequestFormEvent::TYPE_COMPLETED;
        $requestFormEvent->save();
    }
}
