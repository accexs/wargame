<?php


namespace Domain\WarModule\Entities;


use Domain\WarModule\Contracts\ArmyBuilderInterface;
use Domain\WarModule\Contracts\TreasuryInterface;
use Domain\WarModule\Traits\TreasuryTrait;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class Army implements ArmyBuilderInterface, TreasuryInterface
{

    protected $id;

    protected $armyDistribution;

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
        $this->armyDistribution = $this->fillArmy();
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
        if (empty($this->armyDistribution)) {
            throw new Exception('No units on the army');
        }
        $col = $this->armyDistribution->filter(function ($soldier) use ($id) {
            return $soldier['id'] != $id;
        });
        $this->armyDistribution = $col;
        $this->calculateStrength();
    }

    private function calculateStrength(): Collection
    {
        return $this->armyDistribution->sum('strength');
    }

    public function orderUnitsByStrength(int $slice = 0): Collection
    {
        if ($slice > 0) {
            return $this->armyDistribution->sortByDesc('strength')
                ->slice($slice);
        }
        return $this->armyDistribution->sortByDesc('strength');
    }

    public function getArmyDistribution()
    {
        // TODO: identify only updated units.
        $this->armyDistribution->transform(function ($soldier) {
            return $soldier['object']->getStats() + ['object' => $soldier['object']];
        });
        return $this->armyDistribution;
    }

    public function getArmyStats()
    {
        return [
            'id' => $this->id,
            'civilization' => strtolower((new ReflectionClass($this))->getShortName()),
            'name' => $this->name,
            'treasure' => isset($this->treasure) ? $this->treasure : 'N/A',
            'strength' => $this->strength,
            'units' => $this->armyDistribution,
        ];
    }

}
