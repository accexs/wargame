# Wargames

## Installation

Standard installation for a laravel project, no database needed.

## CLI usage

### Create an army:
    $army = CivilizationFactory::createCivilizationArmy('english', 'eng army');

### Train or transform a unit:
Executing `$army->getArmyUnits();` returns a collection so if we want to train or transform the first unit for example:
`$army->getArmyUnits()->first()['object']->training($army);`
or
```$army->getArmyUnits()->first()['object']->transform($army);```

Gold and strength for the army automatically refreshes after the event.

### Battle:

    $battle = new Battle($army1, $army2);

To get the battle result:

    $result = $battle->clash()->generateResults()->getBattleStats();

Treasure and army loses automatically refreshes by the program.

## API usage


There are several endpoints to complete the workflow.

create an army -> POST ```/api/warmodule/army```

body
```json
{
    "name": "My army",
    "civilization": "english"
}
```

list armies -> GET ```/api/warmodule/army```

train unit -> PUT ```/api/warmodule/army/{army_id}/unit/{unit_id}/train```

transform unit -> PUT ```/api/warmodule/army/{army_id}/unit/{unit_id}/transform```

battle -> POST ```/api/warmodule/battle```

body
```json
{
    "attacker_id": "andid",
    "defender_id": "otherid"
}
```
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
