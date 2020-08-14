<?php


namespace Domain\WarModule\Entities\Units;


class Archer extends Soldier
{

    public function __construct()
    {
        parent::__construct();
        $this->strengthPoints = 10;
        $this->ratePoints = 7;
        $this->trainingCost = 20;
    }

    public function transform(): Soldier
    {
        $soldier = new $this->transformTarget['target'];
        $soldier->id = $this->id;
        $soldier->strengthPoints = $this->strengthPoints;
        $soldier->ratePoints = $this->ratePoints;
        return $soldier;
    }
}
