<?php

namespace App\Controllers;

use Simplified\Http\Request;

class Controllerf {
    public function newIndex(Request $req, $arg1, $arg2) {
        print "<p>Hello, is printed output</p>";
        return "<p>" . route("meine.route", array("module" => "gsdf", "id" => "44")) . "</p>";
    }
}