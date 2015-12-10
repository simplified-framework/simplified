<?php

namespace App\Controllers;

use Simplified\Core\Lang;
use Simplified\Http\Request;

class Controller {
    public function newIndex(Request $req, $arg1, $arg2) {
        print Lang::get('globals.hello');
        print "<p>Hello, is printed output</p>";
    }
}