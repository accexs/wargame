<?php

namespace App\Events\Domain\WarModule;

use Domain\WarModule\Entities\Army;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TreasureChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $army;

    public $action;

    public $amount;

    /**
     * Create a new event instance.
     *
     * @param  Army  $army
     * @param $action
     * @param $amount
     */
    public function __construct(Army $army, string $action, int $amount)
    {
        $this->army = $army;
        $this->action = $action;
        $this->amount = $amount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
