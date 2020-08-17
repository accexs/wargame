<?php

namespace App\Providers;

use App\Events\Domain\WarModule\TreasureChanged;
use App\Events\Domain\WarModule\UnitChanged;
use App\Listeners\Domain\WarModule\Listeners\TreasureChangedNotification;
use App\Listeners\Domain\WarModule\Listeners\UnitChangedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UnitChanged::class => [
            UnitChangedNotification::class,
        ],
        TreasureChanged::class => [
            TreasureChangedNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
