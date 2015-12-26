<?php

use Simplified\Http\Route;

Route::get("/{id}", array(
    'as' => 'index.default',
    'uses' => 'Controller@newIndex')
);

