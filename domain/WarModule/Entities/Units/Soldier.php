<?php


namespace Domain\WarModule\Entities\Units;


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
    public abstract function transform(Army $army): Soldier;

}
