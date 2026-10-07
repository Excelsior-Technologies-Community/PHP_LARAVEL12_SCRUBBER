<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScrubberController;

Route::get('/', [ScrubberController::class, 'index'])
    ->name('scrubber.index');

Route::post('/process', [ScrubberController::class, 'process'])
    ->name('scrubber.process');

Route::get('/export', [ScrubberController::class, 'export'])
    ->name('scrubber.export');

Route::delete('/scrubber/{scrubbedData}', [
    ScrubberController::class,
    'destroy'
])->name('scrubber.destroy');

Route::delete('/scrubber-bulk-delete', [
    ScrubberController::class,
    'bulkDelete'
])->name('scrubber.bulkDelete');