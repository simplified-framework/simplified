<?php

use Simplified\Http\Route;

Route::get("/", function(\Simplified\Http\Request $req){
    print "default route called";
});

Route::get("/{module}/abc/{id}", array('as' => 'meine.route', 'uses' => 'Controller@newIndex'))
    ->conditions(array('module' => '[a-zA-Z]+','id' => '\d+'));

Route::delete("/delete", "Controller@delete");
Route::post("/post", "Controller@newIndex")->conditions(array('testme' => "here we are"));
