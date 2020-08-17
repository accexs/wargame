<?php

namespace App\Listeners\Domain\WarModule\Listeners;

use App\Events\Domain\WarModule\TreasureChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TreasureChangedNotification
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
     * @param  TreasureChanged  $event
     * @return void
     */
    public function handle(TreasureChanged $event)
    {
        //
        switch ($event->action) {
            case 'add':
                $event->army->addGold($event->amount);
                break;
            case 'remove':
                $event->army->removeGold($event->amount);
                break;
        }
    }
}
