<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

class Byzantine extends Army
{

    protected $armyInitConfig = [
        'archer' => 8,
        'knight' => 15,
        'pikeman' => 5,
    ];

    public function __construct($name) {
        $this->name = $name;
        $this->initArmy();
    }


}
