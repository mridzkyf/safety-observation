<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        \App\Events\SoSubmitted::class => [
            \App\Listeners\SendEmailOnSoSubmitted::class,
        ],
        \App\Events\SoClosedByManager::class => [
            \App\Listeners\SendEmailOnSoClosedByManager::class,
        ],
        \App\Events\SoOpenedAndAssignedSic::class => [
            \App\Listeners\SendEmailOnSoOpenedAndAssignedSic::class,
        ],
        \App\Events\SicStatusChanged::class => [
            \App\Listeners\SendEmailOnSicStatusChanged::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
