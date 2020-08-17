<?php


namespace Domain\WarModule\Contracts;


use Domain\WarModule\Entities\Army;
use Illuminate\Support\Collection;

/**
 * Interface RecordInterface
 * @package Domain\WarModule\Contracts
 */
interface RecordInterface
{
    /**
     * @param  Army  $opponent
     * @param  string  $result
     * @return Army
     */
    public function generateRecord(Army $opponent, string $result): Army;

    /**
     * @return Collection
     */
    public function getRecord(): Collection;
}
