<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ScrubberController;


Route::get('/', [ScrubberController::class, 'index']);
Route::post('/process', [ScrubberController::class, 'process']);