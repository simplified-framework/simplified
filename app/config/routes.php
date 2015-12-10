<?php

use Simplified\Http\Route;
use Simplified\Http\Request;

Route::get("/", function(Request $req){
    print "We are here";
});

Route::get("/{module}/abc/{id}", array('as' => 'meine.route', 'uses' => 'Controller@newIndex'))
    ->conditions(array('module' => '[a-zA-Z]+','id' => '\d+'));

Route::delete("/destroy", "Controller@destroy");
Route::post("/post", "Controller@newIndex")->conditions(array('testme' => "here we are"));
