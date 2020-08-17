<?php


namespace Domain\WarModule\Entities\Units;


use Domain\WarModule\Entities\Army;

/**
 * Class Knight
 * @package Domain\WarModule\Entities\Units
 */
class Knight extends Soldier
{

    /**
     * Knight constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->strengthPoints = 20;
        $this->ratePoints = 10;
        $this->trainingCost = 30;
    }

    /**
     * @param  Army  $army
     * @return Soldier
     * @throws \Exception
     */
    public function transform(Army $army): Soldier
    {
        throw new \Exception('Knights cant transform into other units');
    }
}
