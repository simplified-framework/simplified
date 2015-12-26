<?php

namespace App\Controllers;

use Simplified\Core\View;

class Controller {
    public function newIndex() {
        $options = array("opt1" => "Option 1", "opt2" => "Option 2");

        $v = new View();
        return $v->render('index.twig', compact('options'));
    }
}