<?php


namespace Domain\WarModule\Entities\Units;


use App\Events\Domain\WarModule\TreasureChanged;
use App\Events\Domain\WarModule\UnitChanged;
use Domain\WarModule\Entities\Army;

/**
 * Class Archer
 * @package Domain\WarModule\Entities\Units
 */
class Archer extends Soldier
{

    /**
     * Archer constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->strengthPoints = 10;
        $this->ratePoints = 7;
        $this->trainingCost = 20;
        $this->transformTarget = [
            'original' => self::class,
            'target' => Knight::class,
            'cost' => 40,
        ];
    }
}
