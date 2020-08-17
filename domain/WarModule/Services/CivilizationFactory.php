<?php


namespace Domain\WarModule\Services;


use Domain\WarModule\Entities\Army;
use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Class CivilizationFactory
 * @package Domain\WarModule\Services
 */
abstract class CivilizationFactory
{

    /**
     * @param  string  $civName
     * @param  string  $armyName
     * @return Army
     * @throws ReflectionException
     */
    public static function createCivilizationArmy(string $civName, string $armyName): Army
    {
        $class = ucfirst($civName);

        $classDir = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR.'Civilizations'.DIRECTORY_SEPARATOR.$class.'.php';
        if (file_exists($classDir)) {
            $class = 'Domain\\WarModule\\Entities\\Civilizations\\'.$class;
            if (class_exists($class)) {
                $reflectionClass = new ReflectionClass($class);
                $army = $reflectionClass->newInstanceArgs([$armyName]);
                $army->initArmy()->raiseArmy();
                return $army;
            } else {
                throw new Exception('Error loading '.$class.' class');
            }
        } else {
            throw new Exception('Error loading '.$classDir.' file');
        }
    }
}
