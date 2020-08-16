<?php

namespace Domain\WarModule\Contracts;

use Domain\WarModule\Services\Battle;

interface BattleInterface
{

    public function clash();

    public function generateResults(): Battle;
}
