<?php

namespace App\Controllers;

use Simplified\Core\Lang;
use Simplified\Core\View;
use Simplified\Http\Request;
use Simplified\Http\Response;

class Controller {
    public function newIndex(Request $req, $arg1, $arg2) {
        $v = new View();
        return $v->render('index.twig');

        /*
        $content =  Lang::get('globals.hello1', array('name' => 'ich'));

        $response = new Response();
        $response->setContent($content);
        $response->send();
        */
    }
}