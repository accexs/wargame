<?php


namespace Domain\WarModule\Contracts;


/**
 * Interface TreasuryInterface
 * @package Domain\WarModule\Contracts
 */
interface TreasuryInterface
{
    /**
     * @param  int  $gold
     * @return mixed
     */
    public function addGold(int $gold);

    /**
     * @param  int  $gold
     * @return mixed
     */
    public function removeGold(int $gold);

    /**
     * @return int
     */
    public function getTreasure(): int;
}
