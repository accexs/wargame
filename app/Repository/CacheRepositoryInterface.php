<?php


namespace App\Repository;


use Domain\WarModule\Entities\Army;
use Illuminate\Support\Collection;

interface CacheRepositoryInterface
{
    /**
     * @param  string  $entity
     * @return Collection
     */
    public function all(string $entity): Collection;

    /**
     * @param  string  $entity
     * @param  string  $id
     * @return Army
     */
    public function find(string $entity, string $id): object;

    /**
     * @param  string  $entityName
     * @param  Collection  $entity
     * @return bool
     */
    public function create(string $entityName, Collection $entity): bool;
}