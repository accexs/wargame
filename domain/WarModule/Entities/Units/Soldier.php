<?php


namespace Domain\WarModule\Entities\Units;


use App\Events\Domain\WarModule\TreasureChanged;
use App\Events\Domain\WarModule\UnitChanged;
use Domain\WarModule\Entities\Army;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;

/**
 * Class Soldier
 * @package Domain\WarModule\Entities\Units
 */
abstract class Soldier
{

    /**
     * @var string
     */
    public $id;

    /**
     * @var
     */
    public $strengthPoints;

    /**
     * @var
     */
    protected $ratePoints;

    /**
     * @var
     */
    protected $trainingCost;

    /**
     * @var
     */
    protected $transformTarget;

    /**
     * Soldier constructor.
     */
    public function __construct()
    {
        $this->id = Str::random(9);
    }

    /**
     * @param  Army  $army
     * @return $this
     */
    public function training(Army $army)
    {
        $this->strengthPoints = $this->strengthPoints + $this->ratePoints;
        event(new UnitChanged($army, $this));
        event(new TreasureChanged($army, "remove", $this->trainingCost));
        return $this;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @param  Army  $army
     * @return Soldier
     */
    public function transform(Army $army): Soldier
    {
        $soldier = new $this->transformTarget['target'];
        $soldier->id = $this->id;
        $soldier->strengthPoints = $this->strengthPoints;
        $soldier->ratePoints = $this->ratePoints;
        event(new UnitChanged($army, $this));
        event(new TreasureChanged($army, "remove", $this->transformTarget['cost']));
        return $soldier;
    }

}
