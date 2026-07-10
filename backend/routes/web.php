<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name'    => 'VT Kindergarten API',
        'version' => '1.0.0',
        'status'  => 'running',
    ]);
});
