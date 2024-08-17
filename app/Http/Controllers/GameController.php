<?php

namespace App\Http\Controllers;

use App\Bet;
use App\GameRound;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $currentRound = GameRound::latest()->first();
        return view('game', compact('currentRound'));
    }

    public function startNewGameRound()
    {
        $crashMultiplier = $this->generateCrashMultiplier();
        $gameRound = GameRound::create([
            'start_time' => now(),
            'crash_multiplier' => $crashMultiplier,
        ]);

        return response()->json($gameRound);
    }

    public function placeBet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $bet = Bet::create([
            'user_id' => auth()->id(),
            'game_round_id' => $request->game_round_id,
            'amount' => $request->amount,
        ]);

        return response()->json($bet);
    }

    public function cashOut(Request $request)
    {
        $bet = Bet::where('user_id', auth()->id())
            ->where('game_round_id', $request->game_round_id)
            ->firstOrFail();

        $gameRound = GameRound::findOrFail($request->game_round_id);

        // Check if the game has crashed
        if ($gameRound->crash_multiplier < $request->multiplier) {
            return response()->json(['error' => 'Game has already crashed.'], 400);
        }

        // If the game hasn't crashed yet, proceed with cash out
        $bet->multiplier = $request->multiplier;
        $bet->cashed_out = true;
        $bet->save();

        return response()->json($bet);
    }

    private function generateCrashMultiplier()
    {
        return round(rand(100, 200) / 100, 2); // Random multiplier between 1.00 and 2.00
    }
}
