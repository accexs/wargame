<?php


namespace Domain\WarModule\Entities\Units;


use App\Events\Domain\WarModule\UnitChanged;
use Domain\WarModule\Entities\Army;

/**
 * Class Pikeman
 * @package Domain\WarModule\Entities\Units
 */
class Pikeman extends Soldier
{

    /**
     * Pikeman constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->strengthPoints = 5;
        $this->ratePoints = 3;
        $this->trainingCost = 10;
        $this->transformTarget = [
            'original' => self::class,
            'target' => Archer::class,
            'cost' => 30,
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
        return $soldier;
    }
}
