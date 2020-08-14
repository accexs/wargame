<?php


namespace Domain\WarModule\Contracts;


interface TreasuryInterface
{
    public function addGold(int $gold);
    public function removeGold(int $gold);
    public function getTreasure(): int;
}
