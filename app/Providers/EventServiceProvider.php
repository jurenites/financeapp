<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\RequestFormSubmitted' => [
            'App\Listeners\AddRequestFormSubmittedEvent',
            'App\Listeners\SendSubmittedEmailToRequester',
            'App\Listeners\SendSubmittedEmailToBudgetManager',
        ],
        'App\Events\RequestFormEdited' => [
            'App\Listeners\AddRequestFormEditedEvent',
        ],
        'App\Events\RequestFormApprovedByManager' => [
            'App\Listeners\AddRequestFormApprovedByManagerEvent',
            'App\Listeners\SendApprovedByManagerEmailToBudgetManager',
            'App\Listeners\SendApprovedByManagerEmailToRequester',
        ],
        'App\Events\RequestFormDeclinedByManager' => [
            'App\Listeners\AddRequestFormDeclinedByManagerEvent',
            'App\Listeners\SendDeclinedByBudgetManagerEmailToRequester',
        ],
        'App\Events\NoteAddedToRequestForm' => [
            'App\Listeners\AddRequestFormNoteAddedEvent',
        ],
        'App\Events\RequestFormApprovedByAdmin' => [
            'App\Listeners\AddRequestFormApprovedByAdminEvent',
        ],
        'App\Events\RequestFormDeclinedByAdmin' => [
            'App\Listeners\AddRequestFormDeclinedByAdminEvent',
            'App\Listeners\SendDeclinedByAdminEmailToBudgetManager',
        ],
        'App\Events\RequestFormPendingBudgetManager' => [
            'App\Listeners\SendPendingRequestFormEmailToBudgetManager',
        ],
        'App\Events\RequestFormCompleted' => [
            'App\Listeners\AddRequestFormCompletedEvent',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
