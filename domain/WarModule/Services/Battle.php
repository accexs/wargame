<?php


namespace Domain\WarModule\Services;


use Domain\WarModule\Contracts\BattleInterface;
use Domain\WarModule\Entities\Army;
use Exception;
use ReflectionException;

/**
 * Class Battle
 * @package Domain\WarModule\Services
 */
class Battle implements BattleInterface
{

    /**
     *
     */
    const IS_TIE = 'tie';

    /**
     *
     */
    const HAS_WINNER = 'has_winner';

    /**
     * @var Army
     */
    protected $defender;

    /**
     * @var Army
     */
    protected $attacker;

    /**
     * @var
     */
    protected $loser;

    /**
     * @var
     */
    protected $winner;

    /**
     * @var int
     */
    public $goldPrize;

    /**
     * @var
     */
    private $battleResult;

    /**
     * Battle constructor.
     * @param  Army  $attacker
     * @param  Army  $defender
     */
    public function __construct(Army $attacker, Army $defender)
    {
        $this->goldPrize = 100;
        $this->attacker = $attacker;
        $this->defender = $defender;
    }

    /**
     * @return $this
     * @throws ReflectionException
     */
    public function clash(): Battle
    {
        $this->battleResult = self::HAS_WINNER;
        $defenderStats = $this->defender->getArmyStats();
        $attackerStats = $this->attacker->getArmyStats();
        if ($attackerStats['strength'] <= 0 and $defenderStats['strength'] <= 0) {
            throw new Exception('Both armies are empty');
        }
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

    /**
     * @return $this
     * @throws Exception
     */
    public function generateResults(): Battle
    {
        if ($this->battleResult === self::IS_TIE) {
            $this->attacker->generateRecord($this->defender, 'tied');
            $this->defender->generateRecord($this->attacker, 'tied');
            $this->attacker->removeUnit($this->attacker->orderUnitsByStrength()
                ->getArmyUnits()
                ->first()['id']);
            $this->defender->removeUnit($this->defender->orderUnitsByStrength()
                ->getArmyUnits()
                ->first()['id']);
            return $this;
        }
        $this->winner->generateRecord($this->defender, 'won');
        $this->loser->generateRecord($this->defender, 'lost');
        $this->winner->addGold(100);
        $this->loser->removeUnit($this->defender->orderUnitsByStrength()
            ->getArmyUnits()
            ->first()['id']);
        $this->loser->removeUnit($this->defender->orderUnitsByStrength()
            ->getArmyUnits()
            ->first()['id']);
        $this->loser->removeGold(100);

        return $this;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getBattleStats()
    {
        if ($this->battleResult == self::HAS_WINNER) {
            return [
                'status' => self::HAS_WINNER,
                'winner' => $this->winner->getArmyStats(),
                'loser' => $this->loser->getArmyStats(),
            ];
        }
        return [
            'status' => self::IS_TIE,
            'attacker' => $this->attacker->getArmyStats(),
            'defender' => $this->defender->getArmyStats(),
        ];
    }
}
