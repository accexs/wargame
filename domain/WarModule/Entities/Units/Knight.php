<?php


namespace Domain\WarModule\Entities\Units;


class Knight extends Soldier
{

    public function __construct()
    {
        parent::__construct();
        $this->strengthPoints = 20;
        $this->ratePoints = 10;
        $this->trainingCost = 30;
    }

    public function transform()
    {
        throw new \Exception('Knights cant transform into other units');
    }
}
