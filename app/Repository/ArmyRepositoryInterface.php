<?php


namespace App\Repository;


use Domain\WarModule\Entities\Army;
use Illuminate\Support\Collection;

/**
 * Interface ArmyRepositoryInterface
 * @package App\Repository
 */
interface ArmyRepositoryInterface
{
    /**
     * @param  string  $civilization
     * @param  string  $name
     * @return Army
     */
    public function createArmy(string $civilization, string $name): Army;

    /**
     * @param  string  $entity
     * @return Collection
     */
    public function allArmies(string $entity = 'armies'): Collection;

    /**
     * @param  string  $id
     * @return Army
     */
    public function findArmy(string $id): Army;

    /**
     * @param  string  $armyId
     * @param  string  $unitId
     * @return array
     */
    public function trainUnit(string $armyId, string $unitId): array;

    /**
     * @param  string  $armyId
     * @param  string  $unitId
     * @return array
     */
    public function transformUnit(string $armyId, string $unitId): array;
}