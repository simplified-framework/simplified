<?php

use Simplified\Http\Route;

Route::get("/", array(
    'as' => 'index.default',
    'uses' => 'Controller@newIndex')
);