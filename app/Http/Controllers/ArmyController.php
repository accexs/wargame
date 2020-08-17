<?php

namespace App\Http\Controllers;

use App\Repository\ArmyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class ArmyController extends Controller
{

    // TODO: think persistence strategy
    // TODO: validate all input
    // TODO: create standard response: success, not found, exception

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
            return response()->json($validator->errors(), 422);
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
        $armies = Cache::get('armies');
        if (empty($armies)) {
            // TODO: return not found
            return response()->json([], 404);
        }
        $armies->transform(function ($army) {
            return $army->getArmyStats() + ['object' => $army];
        });
        $army = $armies->where('id', $army_id)->first();
        // TODO: return not found for unit
        $unit = $army['units']->where('id', $unit_id)
            ->first()['object']->transform($army['object']);
        $armies->transform(function ($army) {
            return $army['object'];
        });
        Cache::put('armies', $armies);
        return ResponseBuilder::success($unit);
    }
}
