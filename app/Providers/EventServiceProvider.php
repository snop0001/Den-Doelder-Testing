<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        AutomaticStatusChange::class => [
            ReadyForProductionPending::class,
            InitialCheckPending::class,
            AdminHold::class,
            InProduction::class,
        ],
        NotePriorityChange::class => [
            PriorityErrorNote::class,
        ],
        StatusChangeProduction::class => [
            Paused::class,
            Production::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
