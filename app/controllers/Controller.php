<?php

namespace App\Controllers;

use Simplified\Core\Lang;
use Simplified\Core\View;
use Simplified\Http\Request;
use Simplified\Http\Response;

class Controller {
    public function newIndex(Request $req, $arg1, $arg2) {
        $v = new View();
        $content = $v->render('index.twig');

        (new Response($content, 200))->send();
    }
}