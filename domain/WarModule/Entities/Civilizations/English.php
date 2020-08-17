<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

/**
 * Class English
 * @package Domain\WarModule\Entities\Civilizations
 */
class English extends Army
{

    /**
     * @var int[]
     */
    protected $armyInitConfig = [
        'archer' => 10,
        'knight' => 10,
        'pikeman' => 10,
    ];

    /**
     * English constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->initArmy();
    }


}
