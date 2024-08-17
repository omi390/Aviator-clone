<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
 // database/migrations/xxxx_xx_xx_create_game_rounds_table.php
public function up()
{
    Schema::create('game_rounds', function (Blueprint $table) {
        $table->id();
        $table->timestamp('start_time');
        $table->decimal('crash_multiplier', 5, 2);
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
        Schema::dropIfExists('game_rounds');
    }
}
