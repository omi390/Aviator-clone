<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    // use HasFactory;

    protected $fillable = ['user_id', 'game_round_id', 'amount', 'multiplier', 'cashed_out'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gameRound()
    {
        return $this->belongsTo(GameRound::class);
    }
}
