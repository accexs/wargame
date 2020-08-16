<?php

namespace App\Http\Controllers;

use Domain\WarModule\Services\CivilizationFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ArmyController extends Controller
{

    // TODO: create an interface and repository class to handle cache
    // TODO: think persistence strategy
    // TODO: validate all input
    // TODO: create standard response: success, not found, exception

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['civilization' => 'required', 'name' => 'required']);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $army = CivilizationFactory::createCivilizationArmy($request->civilization,
            $request->name);
        $armies = Cache::get('armies');
        if (!empty($armies)) {
            $armies = $armies->push($army);
            Cache::put('armies', $armies);
            return response()->json($army->getArmyStats());
        }
        Cache::put('armies', collect([$army]));
        return response()->json(collect($army->getArmyStats()));
    }

    public function index()
    {
        $armies = Cache::get('armies');
        if (empty($armies)) {
            // TODO: change to empty http code
            return response()->json([]);
        }
        $armies->transform(function ($army) {
            return $army->getArmyStats();
        });
        return response()->json($armies);
    }

    public function trainUnit(Request $request, $army_id, $unit_id)
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
            ->first()['object']->training($army['object']);
        $armies->transform(function ($army) {
            return $army['object'];
        });
        Cache::put('armies', $armies);
        return response()->json($unit);
    }

    public function transformUnit(Request $request, $army_id, $unit_id)
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
        return response()->json($unit);
    }
}
