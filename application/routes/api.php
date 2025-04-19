<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')
    ->group(function () {
        Route::post('/short-links', [ShortLinkController::class, 'store']);
    });
