<?php

namespace App\Controllers;

use Simplified\View\View;

class Controller {
    public function index() {
        $v = new View();
        return $v->render('index');
    }
}