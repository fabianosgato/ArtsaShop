<?php

namespace Modules\Sales\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Sales\Events\OrderCreated;
use Modules\Sales\Listeners\SendOrderCreatedEmail;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        OrderCreated::class => [
            SendOrderCreatedEmail::class,
        ],
    ];

    /**
     * Indicates if events should be discovered.
     *
     * @var bool
     */
    protected static $shouldDiscoverEvents = true;

    /**
     * Configure the proper event listeners for email verification.
     * @return void
     */
    protected function configureEmailVerification(): void
    {

    }
}
