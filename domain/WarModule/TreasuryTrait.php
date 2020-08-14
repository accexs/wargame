<?php

namespace Domain\WarModule\Traits;

trait TreasuryTrait
{

    protected $treasure;

    public function addGold(int $gold)
    {
        $this->treasure = $this->treasure + $gold;
    }

    public function removeGold(int $gold)
    {
        // validate negative
        $this->treasure = $this->treasure - $gold;
    }

    public function getTreasure(): int
    {
        return $this->treasure;
    }
}
