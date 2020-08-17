<?php

namespace Domain\WarModule\Traits;

/**
 * Trait TreasuryTrait
 * @package Domain\WarModule\Traits
 */
trait TreasuryTrait
{

    /**
     * @var
     */
    protected $treasure;

    /**
     * @param  int  $gold
     */
    public function addGold(int $gold)
    {
        $this->treasure = $this->treasure + $gold;
    }

    /**
     * @param  int  $gold
     */
    public function removeGold(int $gold)
    {
        // TODO: validate negative
        $this->treasure = $this->treasure - $gold;
    }

    /**
     * @return int
     */
    public function getTreasure(): int
    {
        return $this->treasure;
    }
}
