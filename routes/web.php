<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrubberController;

Route::get('/', [ScrubberController::class, 'index'])
    ->name('scrubber.index');

Route::post('/process', [ScrubberController::class, 'process'])
    ->name('scrubber.process');

Route::get('/export', [ScrubberController::class, 'export'])
    ->name('scrubber.export');