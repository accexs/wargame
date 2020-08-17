<?php

namespace Domain\WarModule\Contracts;

use Domain\WarModule\Entities\Army;

/**
 * Interface ArmyBuilderInterface
 * @package Domain\WarModule\Contracts
 */
interface ArmyBuilderInterface
{

    /**
     * @return Army
     */
    public function initArmy(): Army;

    /**
     * @return Army
     */
    public function raiseArmy(): Army;

    /**
     * @param  string  $id
     * @return Army
     */
    public function removeUnit(string $id): Army;
}
