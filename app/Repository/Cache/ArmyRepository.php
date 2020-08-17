<?php


namespace App\Repository\Cache;


use App\Repository\ArmyRepositoryInterface;
use Domain\WarModule\Entities\Army;
use Domain\WarModule\Services\CivilizationFactory;
use Exception;
use Illuminate\Support\Collection;
use ReflectionException;

/**
 * Class ArmyRepository
 * @package App\Repository\Cache
 */
class ArmyRepository extends BaseRepository implements ArmyRepositoryInterface
{

    /**
     * @param  string  $entity
     * @return Collection
     */
    public function allArmies(string $entity = 'armies'): Collection
    {
        $armies = $this->all($entity);
        if (empty($armies)) {
            return collect();
        }
        return $armies->transform(function ($army) {
            return $army->getArmyStats();
        });
    }


    /**
     * @param  string  $civilization
     * @param  string  $name
     * @return Army
     * @throws ReflectionException
     */
    public function createArmy(string $civilization, string $name): Army
    {
        $army = CivilizationFactory::createCivilizationArmy($civilization, $name);
        $armies = $this->all('armies');
        if ($armies->isNotEmpty()) {
            $armies = $armies->push($army);
            $this->create('armies', $armies);
            return $army;
        }
        $this->create('armies', collect([$army]));
        return $army;
    }

    /**
     * @param  string  $armyId
     * @param  string  $unitId
     * @return array
     * @throws Exception
     */
    public function findArmyUnit(string $armyId, string $unitId): array
    {
        $armies = $this->all('armies');
        if ($armies->isEmpty()) {
            throw new Exception('No armies found');
        }
        $army = $armies->filter(function ($ArmyItem) use ($armyId) {
            return ($ArmyItem->getId() == $armyId);
        })->first();

        return $army->getArmyUnits()->where('id', $unitId)->first() + ['army_object' => $army];
    }


    public function trainUnit(string $armyId, string $unitId): array
    {
        return $this->alterUnit('training', $armyId, $unitId);
    }


    public function transformUnit(string $armyId, string $unitId): array
    {
        return $this->alterUnit('transform', $armyId, $unitId);
    }

    /**
     * @param  string  $action
     * @param  string  $armyId
     * @param  string  $unitId
     * @return array
     * @throws Exception
     */
    private function alterUnit(string $action, string $armyId, string $unitId): array
    {
        $unit = $this->findArmyUnit($armyId, $unitId);
        $unit['object']->$action($unit['army_object']);
        $armies = $this->all('armies');
        $armies->transform(function ($armyItem) use ($unit) {
            if ($armyItem->getId() == $unit['army_object']->getId()) {
                return $unit['army_object'];
            }
            return $armyItem;
        });
        $this->create('armies', $armies);
        return $unit['object']->getStats();
    }

    public function findArmy(string $id): Army
    {
        return $this->find('armies', $id);
    }
}