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
        // TODO: validate negative
        $this->treasure = $this->treasure - $gold;
    }

    // TODO: delete this
    public function getTreasure(): int
    {
        return $this->treasure;
    }
}
