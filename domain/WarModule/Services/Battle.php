<?php


namespace Domain\WarModule\Services;


use Domain\WarModule\Entities\Army;

class Battle
{

    const IS_TIE = 'tie';

    const HAS_WINNER = 'has_winner';

    protected $defender;

    protected $attacker;

    protected $loser;

    protected $winner;

    public $goldPrize;

    private $battleResult;

    public function __construct(Army $attacker, Army $defender)
    {
        $this->goldPrize = 100;
        $this->attacker = $attacker;
        $this->defender = $defender;
    }

    public function clash(): Battle
    {
        $this->battleResult = self::HAS_WINNER;
        $defenderStats = $this->defender->getArmyStats();
        $attackerStats = $this->attacker->getArmyStats();
        if ($attackerStats['strength'] > $defenderStats['strength']) {
            $this->winner = $this->attacker;
            $this->loser = $this->defender;
        } elseif ($attackerStats['strength'] < $defenderStats['strength']) {
            $this->winner = $this->defender;
            $this->loser = $this->attacker;
        } else {
            $this->battleResult = self::IS_TIE;
        }
        return $this;
    }

    public function generateResults(): Battle
    {
        if ($this->battleResult === self::IS_TIE) {
            $this->attacker->removeUnit($this->attacker->orderUnitsByStrength(1));
            $this->defender->removeUnit($this->defender->orderUnitsByStrength(1));
            return $this;
        }
        $this->winner->addGold(100);
        $this->loser->removeUnit($this->defender->orderUnitsByStrength(1));
        $this->loser->removeGold(100);
        return $this;
    }

    public function publishResults()
    {
        // TODO: publish battle result to the battle record with and event, a push to the repo might be enough
    }
}
