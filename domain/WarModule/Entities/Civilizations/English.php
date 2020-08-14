<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

class English extends Army
{

    protected $armyInitConfig = [
        'archer' => 1,
        'knight' => 1,
        'pikeman' => 1,
    ];

    public function __construct($name)
    {
        $this->name = $name;
        $this->initArmy();
    }


}
