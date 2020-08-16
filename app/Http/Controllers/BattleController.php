<?php

namespace App\Http\Controllers;

use Domain\WarModule\Services\Battle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BattleController extends Controller
{
    public function battle(Request $request) {
        $armies = Cache::get('armies');
        if (empty($armies)) {
            // TODO: return not found
            return response()->json([],404);
        }
        $armies->transform(function ($army) {
            return $army->getArmyStats() + ['object' => $army];
        });
        $attArmy = $armies->where('id', $request->attacker_id)->first();
        $defArmy = $armies->where('id', $request->defender_id)->first();
        // TODO: return not found when no armies
        $battle = new Battle($attArmy['object'], $defArmy['object']);
        $result = $battle->clash()->generateResults()->getBattleStats();
        $armies->transform(function ($army) {
            return $army['object'];
        });
        Cache::put('armies', $armies);
        return response()->json($result);
    }
}
