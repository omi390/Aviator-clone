<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameRound extends Model
{
    // use HasFactory;

    protected $fillable = ['start_time', 'crash_multiplier'];

    public function bets()
    {
        return $this->hasMany(Bet::class);
    }
}
