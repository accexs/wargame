<?php


namespace Domain\WarModule\Entities\Units;


use App\Events\Domain\WarModule\UnitChanged;
use Domain\WarModule\Entities\Army;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class Soldier
{

    public $id;

    public $strengthPoints;

    protected $ratePoints;

    protected $trainingCost;

    protected $transformTarget;

    public function __construct()
    {
        $this->id = Str::random(9);
    }

    public function training(Army $army)
    {
        $this->strengthPoints = $this->strengthPoints + $this->ratePoints;
        event(new UnitChanged($army, $this));
        return $this;
    }

    public function getStats()
    {
        return [
            'id' => $this->id,
            'class' => strtolower((new ReflectionClass($this))->getShortName()),
            'strength' => $this->strengthPoints,
            'training_cost' => $this->trainingCost,
            'rate_points' => $this->ratePoints,
        ];
    }

    public abstract function transform(Army $army): Soldier;

}
