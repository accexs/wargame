<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

class Chinese extends Army
{

    protected $armyInitConfig = [
        'archer' => 25,
        'knight' => 2,
        'pikeman' => 2,
    ];

    public function __construct($name) {
        $this->name = $name;
        $this->initArmy();
    }


}
