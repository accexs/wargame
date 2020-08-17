<?php


namespace Domain\WarModule\Entities\Civilizations;


use Domain\WarModule\Entities\Army;

/**
 * Class Chinese
 * @package Domain\WarModule\Entities\Civilizations
 */
class Chinese extends Army
{

    /**
     * @var int[]
     */
    protected $armyInitConfig = [
        'archer' => 25,
        'knight' => 2,
        'pikeman' => 2,
    ];

    /**
     * Chinese constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->initArmy();
    }


}
