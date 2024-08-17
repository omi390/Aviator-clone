<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/', [GameController::class, 'index'])->name('home');
    Route::post('/start-new-game-round', [GameController::class, 'startNewGameRound']);
    Route::post('/place-bet', [GameController::class, 'placeBet']);
    Route::post('/cash-out', [GameController::class, 'cashOut']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
