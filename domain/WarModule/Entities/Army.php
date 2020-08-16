<?php


namespace Domain\WarModule\Entities;


use Domain\WarModule\Contracts\ArmyBuilderInterface;
use Domain\WarModule\Contracts\RecordInterface;
use Domain\WarModule\Contracts\TreasuryInterface;
use Domain\WarModule\Entities\Units\Soldier;
use Domain\WarModule\Traits\TreasuryTrait;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class Army implements ArmyBuilderInterface, TreasuryInterface, RecordInterface
{

    protected $id;

    protected $armyUnits;

    protected $name;

    protected $strength;

    protected $initialized = false;

    protected $active = false;

    protected $record;

    use TreasuryTrait;

    public function initArmy(): Army
    {
        $this->id = Str::random(9);
        $this->treasure = 1000;
        $this->initialized = true;
        $this->record = collect();
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

    public function removeUnit(string $id): Army
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

    private function calculateStrength(): Army
    {
        $this->strength = $this->armyUnits->sum('strength');
        return $this;
    }

    public function orderUnitsByStrength(int $slice = 0): Army
    {
        if ($slice > 0) {
            $this->armyUnits = $this->armyUnits->sortByDesc('strength')
                ->slice($slice);
            return $this;
        }
        $this->armyUnits = $this->armyUnits->sortByDesc('strength')->values();
        return $this;
    }

    public function refreshArmyDistribution(Soldier $changedSoldier = null
    ): Army {
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
        return $this->calculateStrength();
    }

    public function getArmyStats(): array
    {
        return [
            'id' => $this->id,
            'civilization' => strtolower((new ReflectionClass($this))->getShortName()),
            'name' => $this->name,
            'treasure' => isset($this->treasure) ? $this->treasure : 'N/A',
            'strength' => $this->strength,
            'units' => $this->armyUnits,
            'record' => $this->record,
        ];
    }

    public function getArmyUnits()
    {
        return $this->armyUnits;
    }

    public function generateRecord(Army $opponent, $result): Army
    {
        $record['date'] = Carbon::now();
        $record['result'] = $result;
        $record['strength'] = $this->strength;
        $record['opponent'] = [
            'id' => $opponent->id,
            'name' => $opponent->name,
        ];
        $this->record = $this->record->push($record);
        return $this;
    }

    public function getRecord(): Collection
    {
        return $this->record;
    }

}
