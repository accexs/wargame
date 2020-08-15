<?php

namespace App\Listeners\Domain\WarModule\Listeners;

use App\Events\Domain\WarModule\UnitChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnitChangedNotification
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
     * @param  UnitChanged  $event
     *
     * @return void
     */
    public function handle(UnitChanged $event)
    {
        $event->army->refreshArmyDistribution($event->unit);
    }
}
