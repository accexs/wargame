<?php

namespace App\Http\Controllers;

use App\Repository\ArmyRepositoryInterface;
use Domain\WarModule\Services\Battle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class BattleController extends Controller
{

    private $armyRepository;

    public function __construct(ArmyRepositoryInterface $armyRepository)
    {
        $this->armyRepository = $armyRepository;
    }

    public function battle(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['civilization' => 'attacker_id', 'name' => 'defender_id']);

        if ($validator->fails()) {
            return ResponseBuilder::error(400, null, ['errors' => $validator->errors()->all()]);
        }

        // TODO: this logic should be removed from here to a shared responsability (service/repository)
        $attArmy = $this->armyRepository->findArmy($request->attacker_id);
        $defArmy = $this->armyRepository->findArmy($request->defender_id);
        $battle = new Battle($attArmy, $defArmy);
        $result = $battle->clash()->generateResults()->getBattleStats();
        $armies = $this->armyRepository->all('armies');
        $armies->transform(function ($armyItem) use ($attArmy, $defArmy) {
            switch ($armyItem->getId()) {
                case $attArmy->getId():
                    return $attArmy;
                case $defArmy->getId():
                    return $defArmy;
            }
            return $armyItem;
        });
        $this->armyRepository->create('armies', $armies);
        return response()->json($result);
    }
}
