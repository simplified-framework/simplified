<?php

namespace App\Controllers;

use Simplified\Core\View;
use Simplified\Http\Response;

class Controller {
    public function newIndex() {
        $v = new View();
        $content = $v->render('index.twig');
        (new Response($content))->send();
    }
}