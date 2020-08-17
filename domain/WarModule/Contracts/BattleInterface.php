<?php

namespace Domain\WarModule\Contracts;

use Domain\WarModule\Services\Battle;

/**
 * Interface BattleInterface
 * @package Domain\WarModule\Contracts
 */
interface BattleInterface
{

    /**
     * @return mixed
     */
    public function clash();

    /**
     * @return Battle
     */
    public function generateResults(): Battle;
}
