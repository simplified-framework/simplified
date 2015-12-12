<?php

namespace App\Controllers;

use Simplified\Core\Lang;
use Simplified\Http\Request;
use Simplified\Http\Response;

class Controller {
    public function newIndex(Request $req, $arg1, $arg2) {

        print '
        <html>
        <head>
            <link rel="stylesheet" href="/css/app.css"/>
        </head>
        <body>
            <a href="#" class="btn btn-success">Test Button</a>
            <p>Here we are</p>
        </body>
        </html>
        ';

        /*
        $content =  Lang::get('globals.hello1', array('name' => 'ich'));

        $response = new Response();
        $response->setContent($content);
        $response->send();
        */
    }
}