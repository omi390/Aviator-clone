<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
// database/migrations/xxxx_xx_xx_create_bets_table.php
public function up()
{
    Schema::create('bets', function (Blueprint $table) {
        $table->id();
        $table->string('user_id')->constrained();
        $table->string('game_round_id')->constrained();
        $table->decimal('amount', 10, 2);
        $table->decimal('multiplier', 5, 2)->nullable();
        $table->boolean('cashed_out')->default(false);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets');
    }
}
