<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::get('/videos', \App\Http\Controllers\PexelsController::class)
    ->middleware(EnsureTokenIsValid::class);
