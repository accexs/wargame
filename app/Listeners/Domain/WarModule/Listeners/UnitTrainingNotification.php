<?php

namespace App\Listeners\Domain\WarModule\Listeners;

use App\Events\Domain\WarModule\UnitTrained;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnitTrainingNotification
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
     * @param  UnitTrained  $event
     *
     * @return void
     */
    public function handle(UnitTrained $event)
    {
        $event->army->getArmyDistribution();
    }
}
