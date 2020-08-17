<?php

namespace App\Http\Controllers;

use App\Repository\ArmyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ArmyController extends Controller
{

    // TODO: think persistence strategy
    // TODO: extend base controller to handle exceptions

    private $armyRepository;

    public function __construct(ArmyRepositoryInterface $armyRepository)
    {
        $this->armyRepository = $armyRepository;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['civilization' => 'required', 'name' => 'required']);

        if ($validator->fails()) {
            return ResponseBuilder::error(400, null, ['errors' => $validator->errors()->all()]);
        }

        $army = $this->armyRepository->createArmy($request->civilization,
            $request->name);
        return ResponseBuilder::success($army->getArmyStats());
    }

    public function index()
    {
        return ResponseBuilder::success(['armies' => $this->armyRepository->allArmies()]);
    }

    public function trainUnit($army_id, $unit_id)
    {
        $unit = $this->armyRepository->trainUnit($army_id, $unit_id);
        return ResponseBuilder::success($unit);
    }

    public function transformUnit($army_id, $unit_id)
    {
        $unit = $this->armyRepository->transformUnit($army_id, $unit_id);
        return ResponseBuilder::success($unit);
    }
}
