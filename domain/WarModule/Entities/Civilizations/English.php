<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

class English extends Army
{

    protected $armyInitConfig = [
        'archer' => 10,
        'knight' => 10,
        'pikeman' => 10,
    ];

    public function __construct($name)
    {
        $this->name = $name;
        $this->initArmy();
    }


}
