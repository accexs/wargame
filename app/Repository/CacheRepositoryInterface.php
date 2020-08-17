<?php


namespace App\Repository;


use Illuminate\Support\Collection;

interface CacheRepositoryInterface
{
    /**
     * @param  string  $entity
     * @return Collection
     */
    public function all(string $entity): Collection;

    /**
     * @return array
     */
    public function find(): array;

    /**
     * @param  string  $entityName
     * @param  Collection  $entity
     * @return bool
     */
    public function create(string $entityName, Collection $entity): bool;
}