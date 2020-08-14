<?php


namespace Domain\WarModule\Entities\Units;


class Pikeman extends Soldier
{

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

    public function transform(): Soldier
    {
        $soldier = new $this->transformTarget['target'];
        $soldier->id = $this->id;
        $soldier->strengthPoints = $this->strengthPoints;
        $soldier->ratePoints = $this->ratePoints;
        return $soldier;
    }
}
