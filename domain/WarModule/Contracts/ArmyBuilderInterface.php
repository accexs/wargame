<?php

namespace Domain\WarModule\Contracts;

use Domain\WarModule\Entities\Army;

interface ArmyBuilderInterface
{
    public function initArmy(): Army;
    public function raiseArmy(): Army;
}
