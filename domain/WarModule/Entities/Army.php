<?php


namespace Domain\WarModule\Entities;


use Domain\WarModule\Contracts\ArmyBuilderInterface;
use Domain\WarModule\Contracts\TreasuryInterface;
use Domain\WarModule\Entities\Units\Soldier;
use Domain\WarModule\Traits\TreasuryTrait;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class Army implements ArmyBuilderInterface, TreasuryInterface
{

    protected $id;

    protected $armyUnits;

    protected $name;

    protected $strength;

    protected $initialized = false;

    protected $active = false;

    use TreasuryTrait;

    public function initArmy(): Army
    {
        $this->id = Str::random(9);
        $this->treasure = 1000;
        $this->initialized = true;
        return $this;
    }

    public function raiseArmy(): Army
    {
        if (!$this->initialized) {
            throw new Exception('Army not initialized');
        }
        $this->armyUnits = $this->fillArmy();
        $this->orderUnitsByStrength();
        $this->active = true;
        return $this;
    }

    protected function fillArmy(): Collection
    {
        $armyDistribution = [];
        $namespace = 'Domain\\WarModule\\Entities\\Units\\';
        foreach ($this->armyInitConfig as $class => $n) {
            for ($i = 0; $i < $n; $i++) {
                $soldier = $namespace.$class;
                $soldier = new $soldier;
                $this->strength = $this->strength + $soldier->strengthPoints;
                $armyDistribution[] = $soldier->getStats() + ['object' => $soldier];
            }
        }
        return collect($armyDistribution);
    }

    public function removeUnit(string $id)
    {
        if (empty($this->armyUnits)) {
            throw new Exception('No units on the army');
        }
        $col = $this->armyUnits->filter(function ($unit) use ($id) {
            return $unit['id'] != $id;
        });
        $this->armyUnits = $col->values();
        $this->calculateStrength();
        return $this;
    }

    private function calculateStrength()
    {
        $this->strength = $this->armyUnits->sum('strength');
        return $this;
    }

    public function orderUnitsByStrength(int $slice = 0): Collection
    {
        if ($slice > 0) {
            return $this->armyUnits->sortByDesc('strength')
                ->slice($slice);
        }
        return $this->armyUnits->sortByDesc('strength');
    }

    public function refreshArmyDistribution(Soldier $changedSoldier = null)
    {
        if (empty($changedSoldier)) {
            $this->armyUnits->transform(function ($soldier) {
                return $soldier['object']->getStats() + ['object' => $soldier['object']];
            });
            $this->calculateStrength();
            return $this->armyUnits;
        }
        $this->armyUnits->transform(function ($soldier) use ($changedSoldier) {
            if ($changedSoldier->id === $soldier['id']) {
                return $changedSoldier->getStats() + ['object' => $changedSoldier];
            }
            return $soldier;
        });
        $this->calculateStrength();
        return $this->armyUnits;
    }

    public function getArmyStats()
    {
        return [
            'id' => $this->id,
            'civilization' => strtolower((new ReflectionClass($this))->getShortName()),
            'name' => $this->name,
            'treasure' => isset($this->treasure) ? $this->treasure : 'N/A',
            'strength' => $this->strength,
            'units' => $this->armyUnits,
        ];
    }

    public function getArmyUnits() {
        return $this->armyUnits;
    }

}
