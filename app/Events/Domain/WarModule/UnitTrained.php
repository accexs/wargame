<?php

namespace App\Events\Domain\WarModule;

use Domain\WarModule\Entities\Army;
use Domain\WarModule\Entities\Units\Soldier;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UnitTrained
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $unit;

    public $army;

    /**
     * Create a new event instance.
     *
     * @param  \Domain\WarModule\Entities\Army  $army
     * @param  \Domain\WarModule\Entities\Units\Soldier  $unit
     */
    public function __construct(Army $army, Soldier $unit)
    {
        $this->unit = $unit;
        $this->army = $army;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
