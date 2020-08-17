<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

/**
 * Class Byzantine
 * @package Domain\WarModule\Entities\Civilizations
 */
class Byzantine extends Army
{

    /**
     * @var int[]
     */
    protected $armyInitConfig = [
        'archer' => 8,
        'knight' => 15,
        'pikeman' => 5,
    ];

    /**
     * Byzantine constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->initArmy();
    }


}
