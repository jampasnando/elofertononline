<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',function(){
    return redirect()->route('market.index');
});
Route::get('market', [App\Http\Controllers\MarketController::class, 'index'])->name('market.index');
Route::get('buscar', [App\Http\Controllers\MarketController::class, 'buscar'])->name('market.buscar');
// Route::post('buscar',function(){
//     echo "hola";
// });