<?php


namespace App\Repository\Cache;


use App\Repository\CacheRepositoryInterface;
use Domain\WarModule\Entities\Army;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 * Class BaseRepository
 * @package App\Repository\Cache
 */
class BaseRepository implements CacheRepositoryInterface
{

    public function all(string $entity): Collection
    {
        return Cache::get($entity) ? Cache::get($entity) : collect();
    }

    public function find(string $entityName, string $id): object
    {
        $entities = $this->all($entityName);
        if (empty($entities)) {
            throw new \Exception('not found');
        }

        return $entities->filter(function ($entity) use ($id) {
            return ($entity->getId() == $id);
        })->first();
    }

    public function create(string $entityName, Collection $entity): bool
    {
        return Cache::put($entityName, $entity);
    }
}