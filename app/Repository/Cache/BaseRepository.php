<?php


namespace App\Repository\Cache;


use App\Repository\CacheRepositoryInterface;
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

    public function find(): array
    {
        // TODO: Implement find() method.
        return [];
    }

    public function create(string $entityName, Collection $entity): bool
    {
        return Cache::put($entityName, $entity);
    }
}