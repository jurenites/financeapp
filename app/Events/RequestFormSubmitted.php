<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\RequestForm;

class RequestFormSubmitted extends Event
{
    use SerializesModels;

    public $requestForm;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RequestForm $requestForm)
    {
        $this->requestForm = $requestForm;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
