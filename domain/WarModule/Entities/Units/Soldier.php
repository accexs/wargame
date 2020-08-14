<?php


namespace Domain\WarModule\Entities\Units;


use Illuminate\Support\Str;

abstract class Soldier
{

    protected $id;

    protected $strengthPoints;

    protected $ratePoints;

    protected $trainingCost;

    protected $transformTarget;

    public function __construct()
    {
        $this->id = Str::random(9);
    }

    public function training()
    {
        $this->strengthPoints = $this->strengthPoints + $this->ratePoints;
    }

    public function getStats()
    {
        return [
            'id' => $this->id,
            'class' => strtolower((new \ReflectionClass($this))->getShortName()),
            'strength' => $this->strengthPoints,
            'training_cost' => $this->trainingCost,
            'rate_points' => $this->ratePoints,
        ];
    }

    public function __set($name, $value)
    {
        trigger_error('Used magic method to set property'.PHP_EOL,
            E_USER_WARNING);
        $this->$name = $value;
    }

    public function __get($name)
    {
        trigger_error('Used magic method to access property'.PHP_EOL,
            E_USER_WARNING);
        return $this->$name;
    }

    public abstract function transform();

}
